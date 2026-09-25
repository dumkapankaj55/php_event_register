/* ── helpers ── */
const $ = id => document.getElementById(id);

function showToast(msg, type = 'success') {
  const t = $('toast');
  t.textContent = msg;
  t.className = 'show ' + type;
  clearTimeout(t._timer);
  t._timer = setTimeout(() => t.className = '', 2800);
}

function setError(fieldId, on) {
  const el = $(fieldId);
  el.classList.toggle('has-error', on);
}

/* ── validation ── */
function validateMain() {
  const name  = $('name').value.trim();
  const email = $('email').value.trim();
  const phone = $('phone').value.trim();
  const event = $('event').value.trim();

  let ok = true;
  setError('field-name',  !name);
  setError('field-email', !email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email));
  setError('field-phone', !phone || !/^\d{10}$/.test(phone));
  setError('field-event', !event);

  if (!name || !event) ok = false;
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) ok = false;
  if (!phone || !/^\d{10}$/.test(phone)) ok = false;
  return ok;
}

function validateModal() {
  const name  = $('m-name').value.trim();
  const email = $('m-email').value.trim();
  const phone = $('m-phone').value.trim();
  const event = $('m-event').value.trim();

  let ok = true;
  setError('m-field-name',  !name);
  setError('m-field-email', !email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email));
  setError('m-field-phone', !phone || !/^\d{10}$/.test(phone));
  setError('m-field-event', !event);

  if (!name || !event) ok = false;
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) ok = false;
  if (!phone || !/^\d{10}$/.test(phone)) ok = false;
  return ok;
}

/* ── clear error on input ── */
['name','email','phone','event'].forEach(f => {
  const inp = $(f);
  if (inp) inp.addEventListener('input', () => {
    const field = $('field-' + f);
    if (field) field.classList.remove('has-error');
  });
});
['m-name','m-email','m-phone','m-event'].forEach(f => {
  const inp = $(f);
  if (inp) inp.addEventListener('input', () => {
    const key = f.replace('m-', '');
    const field = $('m-field-' + key);
    if (field) field.classList.remove('has-error');
  });
});

/* ── fetch all ── */
let allRows = [];

async function loadTable() {
  try {
    const res  = await fetch('fetch.php');
    const data = await res.json();
    allRows = data;
    renderTable(data);
  } catch {
    showToast('Could not load registrations.', 'error');
  }
}

function renderTable(data) {
  const tbody = $('table-body');
  const empty = $('empty-state');
  const badge = $('count-badge');

  badge.textContent = data.length + (data.length === 1 ? ' entry' : ' entries');

  if (!data.length) {
    tbody.innerHTML = '';
    empty.style.display = '';
    return;
  }
  empty.style.display = 'none';

  tbody.innerHTML = data.map((r, i) => `
    <tr>
      <td>${i + 1}</td>
      <td class="td-name">${esc(r.name)}</td>
      <td class="td-email">${esc(r.email)}</td>
      <td>${esc(r.phone)}</td>
      <td><span class="td-event">${esc(r.event)}</span></td>
      <td>
        <div class="actions">
          <button class="btn btn-outline btn-sm" onclick="openEdit('${esc(r.id)}')">✎ Edit</button>
          <button class="btn btn-danger  btn-sm" onclick="deleteReg('${esc(r.id)}')">✕ Delete</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function esc(s) {
  return String(s)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ── search ── */
function filterTable() {
  const q = $('search-input').value.toLowerCase();
  const filtered = allRows.filter(r =>
    r.name.toLowerCase().includes(q) ||
    r.email.toLowerCase().includes(q) ||
    r.event.toLowerCase().includes(q)
  );
  renderTable(filtered);
}

/* ── submit (create) ── */
async function submitForm() {
  if (!validateMain()) return;

  const body = new URLSearchParams({
    name:  $('name').value.trim(),
    email: $('email').value.trim(),
    phone: $('phone').value.trim(),
    event: $('event').value.trim(),
  });

  try {
    const res  = await fetch('save.php', { method: 'POST', body });
    const data = await res.json();
    if (data.success) {
      showToast('✦ Registration saved!', 'success');
      clearMainForm();
      loadTable();
    } else {
      showToast(data.message || 'Error saving.', 'error');
    }
  } catch {
    showToast('Server error.', 'error');
  }
}

function clearMainForm() {
  ['name','email','phone','event'].forEach(f => { $(f).value = ''; });
  ['field-name','field-email','field-phone','field-event'].forEach(f => {
    $(f).classList.remove('has-error');
  });
}

/* ── edit modal ── */
function openEdit(id) {
  const row = allRows.find(r => r.id === id);
  if (!row) return;
  $('m-name').value  = row.name;
  $('m-email').value = row.email;
  $('m-phone').value = row.phone;
  $('m-event').value = row.event;
  $('m-id').value    = id;
  ['m-field-name','m-field-email','m-field-phone','m-field-event'].forEach(f =>
    $(f).classList.remove('has-error')
  );
  $('modal-overlay').classList.add('open');
}

function closeModal() {
  $('modal-overlay').classList.remove('open');
}

async function saveEdit() {
  if (!validateModal()) return;

  const body = new URLSearchParams({
    id:    $('m-id').value,
    name:  $('m-name').value.trim(),
    email: $('m-email').value.trim(),
    phone: $('m-phone').value.trim(),
    event: $('m-event').value.trim(),
  });

  try {
    const res  = await fetch('update.php', { method: 'POST', body });
    const data = await res.json();
    if (data.success) {
      showToast('✦ Registration updated!', 'success');
      closeModal();
      loadTable();
    } else {
      showToast(data.message || 'Error updating.', 'error');
    }
  } catch {
    showToast('Server error.', 'error');
  }
}

/* ── delete ── */
async function deleteReg(id) {
  if (!confirm('Delete this registration?')) return;

  const body = new URLSearchParams({ id });
  try {
    const res  = await fetch('delete.php', { method: 'POST', body });
    const data = await res.json();
    if (data.success) {
      showToast('Registration deleted.', 'success');
      loadTable();
    } else {
      showToast(data.message || 'Error deleting.', 'error');
    }
  } catch {
    showToast('Server error.', 'error');
  }
}

/* ── close modal on overlay click ── */
$('modal-overlay').addEventListener('click', e => {
  if (e.target === $('modal-overlay')) closeModal();
});

/* ── init ── */
loadTable();
