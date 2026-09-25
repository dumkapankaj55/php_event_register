<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Event Registration</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="wrapper">

  <!-- HEADER -->
  <header>
    <div class="tag">✦ Registration Portal</div>
    <h1>Event <em>Registration</em> System</h1>
    <p>Add, view, edit, and delete event registrations — all stored locally.</p>
  </header>

  <!-- REGISTRATION FORM -->
  <div class="card" id="form-card">
    <div class="card-title"><span>✦</span> <span id="form-title">New Registration</span></div>

    <div class="form-grid">

      <div class="field" id="field-name">
        <label for="name">Full Name</label>
        <input type="text" id="name" placeholder="e.g. Priya Sharma" autocomplete="off" />
        <span class="err-msg">Please enter your full name.</span>
      </div>

      <div class="field" id="field-email">
        <label for="email">Email Address</label>
        <input type="email" id="email" placeholder="e.g. priya@example.com" autocomplete="off" />
        <span class="err-msg">Please enter a valid email address.</span>
      </div>

      <div class="field" id="field-phone">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" placeholder="e.g. 9876543210" autocomplete="off" />
        <span class="err-msg">Enter a valid 10-digit phone number.</span>
      </div>

      <div class="field" id="field-event">
        <label for="event">Event Name</label>
        <input type="text" id="event" placeholder="e.g. Tech Summit 2026" autocomplete="off" />
        <span class="err-msg">Please enter the event name.</span>
      </div>

    </div>

    <div class="btn-row">
      <button class="btn btn-primary" id="submit-btn" onclick="submitForm()">Register</button>
      <button class="btn btn-outline" id="cancel-btn" onclick="cancelEdit()" style="display:none">Cancel</button>
    </div>
  </div>

  <!-- REGISTRATIONS TABLE -->
  <div class="card">
    <div class="card-title"><span>☰</span> <span>All Registrations</span></div>

    <div class="search-row">
      <input type="text" id="search-input" placeholder="Search by name, email or event…" oninput="filterTable()" />
      <span class="count-badge" id="count-badge">0 entries</span>
    </div>

    <div class="table-wrap">
      <table id="reg-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Event</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="table-body">
          <!-- populated by JS -->
        </tbody>
      </table>
      <div class="empty" id="empty-state" style="display:none">
        <div class="icon">📋</div>
        <p>No registrations yet. Add one above!</p>
      </div>
    </div>
  </div>

</div><!-- /wrapper -->

<!-- EDIT MODAL -->
<div id="modal-overlay">
  <div id="modal">
    <h2>Edit Registration</h2>

    <div class="form-grid">

      <div class="field" id="m-field-name">
        <label>Full Name</label>
        <input type="text" id="m-name" placeholder="Full Name" />
        <span class="err-msg">Please enter your full name.</span>
      </div>

      <div class="field" id="m-field-email">
        <label>Email Address</label>
        <input type="email" id="m-email" placeholder="Email" />
        <span class="err-msg">Please enter a valid email.</span>
      </div>

      <div class="field" id="m-field-phone">
        <label>Phone Number</label>
        <input type="tel" id="m-phone" placeholder="Phone" />
        <span class="err-msg">Enter a valid 10-digit phone number.</span>
      </div>

      <div class="field" id="m-field-event">
        <label>Event Name</label>
        <input type="text" id="m-event" placeholder="Event Name" />
        <span class="err-msg">Please enter the event name.</span>
      </div>

    </div>

    <input type="hidden" id="m-id" />

    <div class="btn-row">
      <button class="btn btn-primary" onclick="saveEdit()">Save Changes</button>
      <button class="btn btn-outline" onclick="closeModal()">Cancel</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script src="script.js"></script>
</body>
</html>
