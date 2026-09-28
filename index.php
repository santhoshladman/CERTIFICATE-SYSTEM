<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate System — SBM Polytechnic College</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<style>
  :root{
    --navy:#132b4c; --navy-deep:#0c1d35; --navy-mid:#1e3a63;
    --brass:#b3893a; --brass-light:#d9b26a;
    --paper:#fbf8f1; --ink:#1c1c1c; --line:#dfe3ea; --panel:#ffffff; --bg:#eef1f5;
    --muted:#6b7280; --danger:#a3352f; --success:#2f6b4f;
    --radius:10px; --shadow:0 8px 24px rgba(12,29,53,.10);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{ background:var(--bg); color:var(--ink); font-family:'Inter',system-ui,sans-serif; min-height:100vh; }
  h1,h2,h3{ font-family:'Inter',system-ui,sans-serif; }

  .btn{ border:none; border-radius:8px; padding:10px 16px; font-family:inherit; font-size:13.5px; font-weight:600;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:transform .12s ease, box-shadow .12s ease, background .12s ease; white-space:nowrap; }
  .btn:active{transform:translateY(1px);}
  .btn-brass{ background:linear-gradient(135deg,var(--brass-light),var(--brass)); color:var(--navy-deep); }
  .btn-brass:hover{ box-shadow:0 4px 14px rgba(179,137,58,.45); }
  .btn-ghost-dark{ background:rgba(255,255,255,.08); color:#fff; border:1px solid rgba(255,255,255,.25); }
  .btn-ghost-dark:hover{ background:rgba(255,255,255,.16); }
  .btn-primary{ background:var(--navy); color:#fff; }
  .btn-primary:hover{ background:var(--navy-mid); }
  .btn-outline{ background:#fff; color:var(--navy); border:1.5px solid var(--line); }
  .btn-outline:hover{ border-color:var(--navy-mid); }
  .btn-danger-outline{ background:#fff; color:var(--danger); border:1.5px solid #f0d3d1; }
  .btn-danger-outline:hover{ background:#fdf3f2; }
  .btn-sm{ padding:7px 11px; font-size:12.5px; border-radius:7px; }
  .btn:disabled{ opacity:.5; cursor:not-allowed; }
  .btn-block{ width:100%; justify-content:center; }

  /* ===== LOGIN ===== */
  .login-overlay{ position:fixed; inset:0; z-index:500; display:flex; align-items:center; justify-content:center;
    background:radial-gradient(circle at 30% 20%, #1e3a63, #0c1d35 70%); padding:20px; }
  .login-card{ width:100%; max-width:380px; background:var(--panel); border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.4); overflow:hidden; }
  .login-head{ background:linear-gradient(135deg,var(--navy-deep),var(--navy)); color:#fff; padding:28px 26px 22px; text-align:center; }
  .login-head .brand-mark{ width:52px;height:52px;border-radius:50%; margin:0 auto 12px;
    background:radial-gradient(circle at 35% 30%, var(--brass-light), var(--brass) 60%, #8a672a 100%);
    display:flex;align-items:center;justify-content:center; font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy-deep);
    font-size:17px; box-shadow:inset 0 0 0 2px rgba(255,255,255,.35), 0 2px 6px rgba(0,0,0,.3); }
  .login-head h1{ margin:0; font-size:17px; }
  .login-head p{ margin:4px 0 0; font-size:12px; color:#c9d4e4; }
  .login-body{ padding:26px; }
  .login-body .field{ margin-bottom:14px; }
  .login-body label{ display:block; font-size:12.5px; font-weight:600; color:var(--navy); margin-bottom:5px; }
  .login-body input, .login-body select{ width:100%; padding:11px 12px; border:1.5px solid var(--line); border-radius:8px; font-family:inherit; font-size:14px; background:#fbfbfc; }
  .login-body input:focus{ outline:none; border-color:var(--navy-mid); background:#fff; }
  .login-error{ background:#fdf1f0; color:var(--danger); font-size:12.5px; padding:9px 12px; border-radius:7px; margin-bottom:14px; display:none; }
  .login-error.show{ display:block; }
  .login-hint{ margin-top:16px; font-size:11.5px; color:var(--muted); text-align:center; line-height:1.6; }

  /* ===== APP SHELL ===== */
  .app-shell{ display:none; min-height:100vh; }
  .app-shell.active{ display:flex; }
  .sidebar{ width:236px; flex-shrink:0; background:linear-gradient(180deg,var(--navy-deep),var(--navy)); color:#fff;
    display:flex; flex-direction:column; position:sticky; top:0; height:100vh; overflow-y:auto; z-index:15; }
  .sidebar-brand{ padding:20px 18px; display:flex; gap:12px; align-items:center; border-bottom:1px solid rgba(255,255,255,.12); }
  .sidebar-brand .brand-mark{ width:38px;height:38px;border-radius:50%; flex-shrink:0;
    background:radial-gradient(circle at 35% 30%, var(--brass-light), var(--brass) 60%, #8a672a 100%);
    display:flex;align-items:center;justify-content:center; font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy-deep); font-size:13px;
    box-shadow:inset 0 0 0 2px rgba(255,255,255,.35); }
  .sidebar-brand .bt h1{ margin:0; font-size:14.5px; line-height:1.25; }
  .sidebar-brand .bt p{ margin:2px 0 0; font-size:10.5px; color:#9fb0c8; }
  .sidebar-nav{ padding:14px 10px; flex:1; }
  .nav-group-label{ font-size:10px; text-transform:uppercase; letter-spacing:.7px; color:#7c8fac; font-weight:700; padding:14px 10px 6px; }
  .nav-item{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; color:#c9d4e4; font-size:13.5px;
    font-weight:600; cursor:pointer; margin-bottom:3px; transition:background .12s,color .12s; }
  .nav-item svg{ flex-shrink:0; opacity:.9; }
  .nav-item:hover{ background:rgba(255,255,255,.08); color:#fff; }
  .nav-item.active{ background:linear-gradient(135deg,var(--brass-light),var(--brass)); color:var(--navy-deep); }
  .nav-item.active svg{ opacity:1; }
  .nav-item.locked{ opacity:.4; cursor:not-allowed; }
  .nav-item.locked:hover{ background:none; color:#c9d4e4; }
  .sidebar-user{ padding:14px 16px; border-top:1px solid rgba(255,255,255,.12); }
  .sidebar-user .u-row{ display:flex; align-items:center; gap:10px; margin-bottom:10px; }
  .u-avatar{ width:34px;height:34px;border-radius:50%; background:rgba(255,255,255,.12); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; flex-shrink:0; }
  .u-name{ font-size:13px; font-weight:700; }
  .u-role{ font-size:10.5px; color:#9fb0c8; text-transform:uppercase; letter-spacing:.5px; }

  .main-area{ flex:1; min-width:0; }
  .topbar-slim{ background:#fff; border-bottom:1px solid var(--line); padding:16px 26px; display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; position:sticky; top:0; z-index:10; }
  .page-title{ margin:0; font-size:19px; color:var(--navy); }
  .page-sub{ margin:2px 0 0; font-size:12.5px; color:var(--muted); }
  .container{ max-width:1180px; margin:0 auto; padding:24px 26px 60px; }
  .page{ display:none; }
  .page.active{ display:block; }

  .role-badge{ display:inline-block; font-size:10px; font-weight:700; padding:3px 8px; border-radius:999px; text-transform:uppercase; letter-spacing:.4px; }
  .role-badge.admin{ background:#fdf0dc; color:#8a5a1a; }
  .role-badge.staff{ background:#e4eefb; color:#1c4f8a; }

  /* ===== Toolbar / search ===== */
  .toolbar{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; background:var(--panel); padding:14px 16px; border-radius:var(--radius); box-shadow:var(--shadow); margin-bottom:18px; }
  .search-wrap{ flex:1 1 260px; position:relative; display:flex; align-items:center; }
  .search-wrap input{ width:100%; padding:10px 14px 10px 38px; border-radius:8px; border:1.5px solid var(--line); font-family:inherit; font-size:14px; background:#f7f8fa; }
  .search-wrap input:focus{ outline:none; border-color:var(--navy-mid); background:#fff; }
  .search-icon{ position:absolute; left:12px; opacity:.5; }
  .toolbar-right{ display:flex; gap:8px; flex-wrap:wrap; }
  .stat-pill{ background:#f1f4f8; border:1px solid var(--line); border-radius:999px; padding:6px 14px; font-size:12.5px; font-weight:600; color:var(--navy); }

  /* ===== Stat cards ===== */
  .stat-cards{ display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
  .stat-card{ background:var(--panel); border-radius:var(--radius); box-shadow:var(--shadow); padding:16px 18px; }
  .stat-card .n{ font-size:24px; font-weight:800; color:var(--navy); }
  .stat-card .l{ font-size:12px; color:var(--muted); margin-top:2px; font-weight:600; }
  @media screen and (max-width:900px){ .stat-cards{ grid-template-columns:repeat(2,1fr); } }

  /* ===== Table ===== */
  .table-card{ background:var(--panel); border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden; }
  table{ width:100%; border-collapse:collapse; }
  thead th{ text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:.6px; color:var(--muted); background:#f6f7fa; padding:12px 16px; border-bottom:1px solid var(--line); font-weight:700; }
  tbody td{ padding:13px 16px; border-bottom:1px solid #f0f1f4; font-size:14px; vertical-align:middle; }
  tbody tr:hover{ background:#f9fafc; }
  tbody tr:last-child td{ border-bottom:none; }
  .stu-name{ font-weight:700; color:var(--navy); cursor:pointer; background:none; border:none; font-family:inherit; font-size:14px; padding:0; text-align:left; }
  .stu-name:hover{ text-decoration:underline; }
  .stu-sub{ font-size:12px; color:var(--muted); margin-top:2px; }
  .row-actions{ display:flex; gap:6px; justify-content:flex-end; flex-wrap:nowrap; }
  .icon-btn{ width:32px; height:32px; border-radius:7px; border:1.5px solid var(--line); background:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; color:var(--navy); transition:background .12s; }
  .icon-btn:hover{ background:#eef1f6; }
  .icon-btn.danger{ color:var(--danger); }
  .icon-btn.danger:hover{ background:#fdf1f0; }
  .gen-btn{ background:var(--navy); color:#fff; border:none; border-radius:7px; padding:8px 13px; font-size:12.5px; font-weight:700; cursor:pointer; }
  .gen-btn:hover{ background:var(--navy-mid); }

  .empty-state{ text-align:center; padding:60px 20px; color:var(--muted); }
  .empty-state svg{ opacity:.35; margin-bottom:14px; }
  .empty-state h3{ margin:0 0 6px; color:var(--navy); font-size:16px; }
  .empty-state p{ margin:0 0 18px; font-size:13.5px; }

  /* ===== Modal ===== */
  .modal-overlay{ position:fixed; inset:0; background:rgba(12,20,35,.55); backdrop-filter:blur(2px); display:none; align-items:flex-start; justify-content:center; z-index:100; padding:32px 16px; overflow-y:auto; }
  .modal-overlay.open{ display:flex; }
  .modal{ background:var(--panel); border-radius:14px; width:100%; max-width:640px; box-shadow:0 20px 60px rgba(0,0,0,.35); animation:pop .16s ease; }
  .modal.modal-lg{ max-width:840px; }
  @keyframes pop{ from{ transform:translateY(10px); opacity:0; } to{ transform:translateY(0); opacity:1; } }
  .modal-head{ display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--line); }
  .modal-head h2{ margin:0; font-size:17px; color:var(--navy); }
  .modal-head p{ margin:2px 0 0; font-size:12.5px; color:var(--muted); }
  .modal-close{ background:none; border:none; font-size:20px; cursor:pointer; color:var(--muted); width:32px; height:32px; border-radius:8px; }
  .modal-close:hover{ background:#f1f2f5; color:var(--ink); }
  .modal-body{ padding:22px; max-height:72vh; overflow-y:auto; }
  .modal-foot{ padding:16px 22px; border-top:1px solid var(--line); display:flex; justify-content:flex-end; gap:10px; flex-wrap:wrap; }
  .modal-foot .left-actions{ margin-right:auto; display:flex; gap:10px; flex-wrap:wrap; }

  /* ===== Form ===== */
  .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:14px 16px; }
  .form-grid .full{ grid-column:1/-1; }
  .field label{ display:block; font-size:12.5px; font-weight:600; color:var(--navy); margin-bottom:5px; }
  .field .hint{ font-weight:400; color:var(--muted); font-size:11px; }
  .field input, .field select, .field textarea{ width:100%; padding:9px 11px; border:1.5px solid var(--line); border-radius:7px; font-family:inherit; font-size:13.5px; background:#fbfbfc; }
  .field input:focus, .field select:focus, .field textarea:focus{ outline:none; border-color:var(--navy-mid); background:#fff; }
  .section-label{ grid-column:1/-1; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:var(--brass); margin:6px 0 -4px; padding-top:8px; border-top:1px dashed var(--line); }
  .section-label.first{ border-top:none; padding-top:0; margin-top:0; }

  /* ===== Student detail view ===== */
  .detail-grid{ display:grid; grid-template-columns:1fr 1fr; gap:12px 20px; }
  .detail-item{ padding:10px 0; border-bottom:1px solid #f2f3f6; }
  .detail-item .k{ font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:var(--muted); font-weight:700; }
  .detail-item .v{ font-size:14.5px; margin-top:3px; color:var(--ink); font-weight:600; }

  /* ===== Bulk import ===== */
  .steps{ display:flex; flex-direction:column; gap:16px; }
  .step-box{ border:1.5px dashed var(--line); border-radius:10px; padding:16px; display:flex; gap:14px; align-items:flex-start; }
  .step-num{ width:26px;height:26px;border-radius:50%;background:var(--navy);color:#fff; display:flex;align-items:center;justify-content:center;font-size:12.5px;font-weight:700;flex-shrink:0; }
  .step-box h4{ margin:0 0 4px; font-size:14px; color:var(--navy); }
  .step-box p{ margin:0 0 10px; font-size:12.5px; color:var(--muted); line-height:1.5; }
  .drop-zone{ border:2px dashed var(--brass); border-radius:8px; padding:18px; text-align:center; background:#fdf9f1; cursor:pointer; font-size:13px; color:var(--navy); }
  .drop-zone.drag{ background:#faf0d9; }
  #csvFileInput{ display:none; }
  .import-summary{ margin-top:12px; padding:12px 14px; border-radius:8px; font-size:13px; display:none; }
  .import-summary.ok{ background:#eef8f2; color:var(--success); display:block; }
  .import-summary.err{ background:#fdf1f0; color:var(--danger); display:block; }

  /* ===== Toast ===== */
  .toast{ position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(20px); background:var(--navy-deep); color:#fff; padding:12px 20px; border-radius:8px; font-size:13.5px; box-shadow:0 8px 24px rgba(0,0,0,.3); z-index:400; opacity:0; transition:all .25s ease; display:flex; align-items:center; gap:10px; pointer-events:none; }
  .toast.show{ opacity:1; transform:translateX(-50%) translateY(0); }
  .toast.success{ background:var(--success); }
  .toast.error{ background:var(--danger); }

  /* ===== Certificate (shared paper look) ===== */
  .cert-toolbar{ display:flex; justify-content:space-between; align-items:center; padding:14px 22px; border-bottom:1px solid var(--line); flex-wrap:wrap; gap:10px; background:#f7f8fa; }
  .cert-scroll{ padding:26px; background:#dfe3ea; overflow-x:auto; display:flex; justify-content:center; }
  /* True A4 page: 210mm x 297mm, so the on-screen preview matches print/PDF output exactly */
  #certPrintArea{ width:210mm; min-height:297mm; flex-shrink:0; background:var(--paper); color:#111; font-family:'Times New Roman', Times, serif;
    padding:16mm 18mm; position:relative; box-shadow:0 6px 22px rgba(0,0,0,.18);
    display:flex; flex-direction:column; box-sizing:border-box; }
  .cert-header{ position:relative; margin-bottom:6px; }
  .cert-logo-corner{ position:absolute; top:0; left:0; width:86px; }
  .cert-logo{ width:86px; height:auto; max-height:86px; display:block; object-fit:contain; }
  .cert-logo-placeholder{ width:86px; height:86px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; text-align:center; line-height:1.1; color:#16233c; background:#eef0f4; border:1px solid #d7dbe3; }
  .cert-header-text{ text-align:center; padding:0 10px 0 100px; }
  .cert-college-name{ font-size:27px; font-weight:700; letter-spacing:.2px; margin:0; white-space:nowrap; }
  .cert-address{ font-size:13.5px; font-weight:700; margin:8px 0 0; letter-spacing:.1px; white-space:nowrap; }
  .cert-approval{ font-size:11px; font-style:italic; margin:7px 0 0; white-space:nowrap; letter-spacing:-.1px; }
  .cert-contact{ font-size:13.5px; margin:5px 0 0; }
  .cert-rule{ border:none; border-top:2px solid #16233c; margin:16px 0 12px; }
  .cert-title{ text-align:center; font-size:26px; font-weight:700; text-decoration:underline; margin:8px 0 4px; letter-spacing:.6px; }
  .cert-idline{ text-align:center; font-size:14.5px; margin:3px 0; }
  .cert-slrow{ display:flex; justify-content:space-between; font-size:15px; margin:12px 0 18px; font-weight:700; }
  .cert-fields{ margin-top:8px; }
  .cert-field{ display:flex; margin-bottom:17px; font-size:16px; line-height:1.5; }
  .cert-field .num{ width:26px; flex-shrink:0; font-weight:700; }
  .cert-field .label{ width:320px; flex-shrink:0; padding-right:12px; }
  .cert-field .sep{ width:16px; flex-shrink:0; }
  .cert-field .val{ flex:1; font-weight:700; }
  .cert-idrow{ display:flex; justify-content:space-between; font-size:15px; margin:12px 0 6px; font-weight:700; }

  /* ===== Bonafide specific layout ===== */
  .bona-topline{ display:flex; justify-content:space-between; align-items:flex-start; font-size:15px; margin:12px 0 4px; }
  .bona-principal{ font-weight:700; line-height:1.4; }
  .bona-principal small{ display:block; font-weight:400; font-size:13px; }
  .bona-title{ text-align:center; font-size:25px; font-weight:700; text-decoration:underline; margin:26px 0 34px; letter-spacing:.6px; }
  .bona-para{ font-size:17px; line-height:2.1; text-align:justify; margin-bottom:20px; text-indent:38px; }
  .bona-para b{ font-weight:700; }
  .bona-sign-block{ margin-top:50px; display:flex; justify-content:space-between; align-items:flex-end; }
  .bona-seal-placeholder{ width:110px; height:110px; border:2px dashed #8a94a6; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; color:#8a94a6; text-align:center; }
  .bona-sign-text{ text-align:center; font-size:15.5px; font-weight:700; line-height:1.6; }

  @page{ size: A4; margin: 0; }
  @media print{
    body *{ visibility:hidden; }
    #certPrintArea, #certPrintArea *{ visibility:visible; }
    /* position:fixed (not absolute) so this escapes the modal overlay's own
       position:fixed containing block and lands exactly on the printed page,
       instead of being offset by the modal's padding. */
    #certPrintArea{ position:fixed; top:0; left:0; right:0; box-shadow:none; width:210mm; min-height:297mm; margin:0 auto; padding:16mm 18mm; }
  }

  /* ===== Reports ===== */
  .filter-row{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; }
  .filter-chip{ background:#fff; border:1.5px solid var(--line); border-radius:999px; padding:8px 16px; font-size:12.5px; font-weight:600; color:var(--navy); cursor:pointer; }
  .filter-chip.active{ background:var(--navy); color:#fff; border-color:var(--navy); }
  .filter-chip input{ margin-right:4px; }
  .type-tag{ font-size:11px; font-weight:700; padding:3px 9px; border-radius:999px; }
  .type-tag.TC{ background:#e4eefb; color:#1c4f8a; }
  .type-tag.BONAFIDE{ background:#eef6ec; color:#2f6b4f; }

  /* ===== Backup page ===== */
  .backup-card{ background:var(--panel); border-radius:var(--radius); box-shadow:var(--shadow); padding:22px; margin-bottom:16px; }
  .backup-card h3{ margin:0 0 6px; color:var(--navy); font-size:15.5px; }
  .backup-card p{ margin:0 0 14px; font-size:13px; color:var(--muted); line-height:1.6; }
  .backup-status{ display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:8px; background:#f6f7fa; font-size:13px; margin-bottom:14px; }
  .backup-status .dot{ width:9px;height:9px;border-radius:50%; background:var(--muted); flex-shrink:0; }
  .backup-status.ok .dot{ background:var(--success); }
  .backup-status.warn .dot{ background:#c17f1f; }
  .note-box{ background:#fdf9f1; border:1px solid #eddcb0; border-radius:8px; padding:12px 14px; font-size:12.5px; color:#7a5a1c; line-height:1.6; }
  .switch-row{ display:flex; align-items:center; gap:10px; font-size:13px; font-weight:600; color:var(--navy); margin-bottom:14px; }

  /* ===== Users list (Settings) ===== */
  .user-row{ display:flex; align-items:center; justify-content:space-between; padding:11px 14px; border:1.5px solid var(--line); border-radius:8px; margin-bottom:8px; }
  .user-row .un{ font-weight:700; font-size:13.5px; color:var(--navy); }
  .settings-tabs{ display:flex; gap:8px; margin-bottom:16px; }
  .settings-tab-btn{ background:#f1f4f8; border:1.5px solid var(--line); padding:8px 16px; border-radius:8px; font-size:12.5px; font-weight:700; color:var(--navy); cursor:pointer; }
  .settings-tab-btn.active{ background:var(--navy); color:#fff; border-color:var(--navy); }
  .settings-pane{ display:none; }
  .settings-pane.active{ display:block; }

  @media screen and (max-width:900px){
    .app-shell.active{ flex-direction:column; }
    .sidebar{ width:100%; height:auto; position:relative; flex-direction:row; overflow-x:auto; }
    .sidebar-brand{ display:none; }
    .sidebar-nav{ display:flex; padding:8px; }
    .sidebar-user{ display:none; }
    .nav-item{ white-space:nowrap; }
  }
  @media screen and (max-width:720px){
    .form-grid{ grid-template-columns:1fr; }
    .detail-grid{ grid-template-columns:1fr; }
    .container{ padding:16px; }
    thead{ display:none; }
    table, tbody, tr, td{ display:block; width:100%; }
    tbody tr{ border-bottom:1px solid var(--line); padding:10px 4px; }
    tbody td{ border:none; padding:4px 8px; }
    .row-actions{ justify-content:flex-start; margin-top:6px; }
    #certPrintArea{ width:100%; padding:24px 20px; }
    .cert-field{ flex-wrap:wrap; font-size:14px; }
    .cert-field .label{ width:100%; margin-bottom:2px; }
    .cert-field .sep{ display:none; }
    .stat-cards{ grid-template-columns:1fr 1fr; }
  }
</style>
</head>
<body>

  <!-- ============ LOGIN ============ -->
  <div class="login-overlay" id="loginOverlay">
    <div class="login-card">
      <div class="login-head">
        <div class="brand-mark" id="loginBrandMark">SBM</div>
        <h1 id="loginCollegeName">SBM Polytechnic College</h1>
        <p>Certificate Management System — Sign In</p>
      </div>
      <div class="login-body">
        <div class="login-error" id="loginError">Invalid username or password.</div>
        <form id="loginForm" onsubmit="return handleLogin(event)">
          <div class="field">
            <label>Username</label>
            <input type="text" id="li_username" autocomplete="username" required>
          </div>
          <div class="field">
            <label>Password</label>
            <input type="password" id="li_password" autocomplete="current-password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>
      </div>
    </div>
  </div>

  <!-- ============ APP SHELL ============ -->
  <div class="app-shell" id="appShell">

    <div class="sidebar">
      <div class="sidebar-brand">
        <div class="brand-mark" id="brandMark">SBM</div>
        <div class="bt">
          <h1 id="brandCollegeName">SBM Polytechnic</h1>
          <p>Certificate System</p>
        </div>
      </div>
      <div class="sidebar-nav">
        <div class="nav-group-label">Certificates</div>
        <div class="nav-item" data-page="dashboard" onclick="goPage('dashboard')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Students
        </div>
        <div class="nav-item" data-page="tc" onclick="goPage('tc')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg>
          Transfer Certificate
        </div>
        <div class="nav-item" data-page="bonafide" onclick="goPage('bonafide')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
          Bonafide Certificate
        </div>
        <div class="nav-group-label">Records</div>
        <div class="nav-item" data-page="reports" onclick="goPage('reports')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
          Reports
        </div>
        <div class="nav-item" data-page="backup" onclick="goPage('backup')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
          Backup
        </div>
        <div class="nav-group-label">System</div>
        <div class="nav-item" data-page="settings" onclick="goPage('settings')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
          Settings
        </div>
      </div>
      <div class="sidebar-user">
        <div class="u-row">
          <div class="u-avatar" id="sbUserAvatar">A</div>
          <div>
            <div class="u-name" id="sbUserName">Administrator</div>
            <div class="u-role" id="sbUserRole">Admin</div>
          </div>
        </div>
        <div style="display:flex; align-items:center; gap:6px; margin-bottom:10px; font-size:11px; color:#9fb0c8;">
          <span id="backendStatusDot" style="width:8px;height:8px;border-radius:50%;background:#b3261e;display:inline-block;flex-shrink:0;"></span>
          <span>Database sync</span>
        </div>
        <button class="btn btn-ghost-dark btn-sm btn-block" onclick="handleLogout()">Sign Out</button>
      </div>
    </div>

    <div class="main-area">

      <!-- ============ PAGE: DASHBOARD / STUDENTS ============ -->
      <div class="page" id="page-dashboard">
        <div class="topbar-slim">
          <div><h2 class="page-title">Students</h2><p class="page-sub">Master student list — shared by both Transfer Certificate and Bonafide Certificate.</p></div>
          <button class="btn btn-brass" onclick="openStudentModal()">+ Add Student</button>
        </div>
        <div class="container">
          <div class="stat-cards">
            <div class="stat-card"><div class="n" id="statTotalStudents">0</div><div class="l">Total Students</div></div>
            <div class="stat-card"><div class="n" id="statTCIssued">0</div><div class="l">TC Issued</div></div>
            <div class="stat-card"><div class="n" id="statBonaIssued">0</div><div class="l">Bonafide Issued</div></div>
            <div class="stat-card"><div class="n" id="statToday">0</div><div class="l">Issued Today</div></div>
          </div>
          <div class="toolbar">
            <div class="search-wrap">
              <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" id="searchInput" placeholder="Search by name, admission no, register no..." oninput="renderTable()">
            </div>
            <span class="stat-pill" id="countPill">0 students</span>
            <div class="toolbar-right" id="adminOnlyImportExport">
              <button class="btn btn-outline" onclick="openImportModal()">⇩ Bulk Import <span class="role-badge admin">Admin</span></button>
              <button class="btn btn-outline" onclick="exportCSV()">⇧ Export CSV <span class="role-badge admin">Admin</span></button>
            </div>
          </div>
          <div class="table-card">
            <table>
              <thead>
                <tr><th>Student</th><th>Admission No.</th><th>Class / Branch</th><th>Father's Name</th><th style="text-align:right;">Actions</th></tr>
              </thead>
              <tbody id="tableBody"></tbody>
            </table>
            <div class="empty-state" id="emptyState" style="display:none;">
              <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#132b4c" stroke-width="1.4"><path d="M9 12h6M9 16h6M9 8h6M5 21V5a2 2 0 0 1 2-2h7l5 5v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z"/></svg>
              <h3>No students found</h3>
              <p>Add a student manually or bulk-import a CSV file to get started.</p>
              <button class="btn btn-brass" onclick="openStudentModal()">+ Add Student</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ============ PAGE: TRANSFER CERTIFICATE ============ -->
      <div class="page" id="page-tc">
        <div class="topbar-slim">
          <div><h2 class="page-title">Transfer Certificate</h2><p class="page-sub">Pick a student and generate their Transfer Certificate.</p></div>
        </div>
        <div class="container">
          <div class="toolbar">
            <div class="search-wrap">
              <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" id="tcSearchInput" placeholder="Search by name, admission no..." oninput="renderTCList()">
            </div>
            <span class="stat-pill" id="tcCountPill">0 students</span>
          </div>
          <div class="table-card">
            <table>
              <thead><tr><th>Student</th><th>Admission No.</th><th>Class at Leaving</th><th style="text-align:right;">Action</th></tr></thead>
              <tbody id="tcListBody"></tbody>
            </table>
            <div class="empty-state" id="tcEmptyState" style="display:none;">
              <h3>No students yet</h3><p>Add students first from the Students page.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ============ PAGE: BONAFIDE CERTIFICATE ============ -->
      <div class="page" id="page-bonafide">
        <div class="topbar-slim">
          <div><h2 class="page-title">Bonafide Certificate</h2><p class="page-sub">Pick a student and generate their Bonafide Certificate.</p></div>
        </div>
        <div class="container">
          <div class="toolbar">
            <div class="search-wrap">
              <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" id="bonaSearchInput" placeholder="Search by name, admission no..." oninput="renderBonaList()">
            </div>
            <span class="stat-pill" id="bonaCountPill">0 students</span>
          </div>
          <div class="table-card">
            <table>
              <thead><tr><th>Student</th><th>Admission No.</th><th>Year / Branch</th><th style="text-align:right;">Action</th></tr></thead>
              <tbody id="bonaListBody"></tbody>
            </table>
            <div class="empty-state" id="bonaEmptyState" style="display:none;">
              <h3>No students yet</h3><p>Add students first from the Students page.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ============ PAGE: REPORTS ============ -->
      <div class="page" id="page-reports">
        <div class="topbar-slim">
          <div><h2 class="page-title">Reports</h2><p class="page-sub">Every certificate issued is logged here automatically, with date and time.</p></div>
        </div>
        <div class="container">
          <div class="stat-cards">
            <div class="stat-card"><div class="n" id="rStatToday">0</div><div class="l">Today</div></div>
            <div class="stat-card"><div class="n" id="rStatMonth">0</div><div class="l">This Month</div></div>
            <div class="stat-card"><div class="n" id="rStatYear">0</div><div class="l">This Year</div></div>
            <div class="stat-card"><div class="n" id="rStatAll">0</div><div class="l">All Time</div></div>
          </div>
          <div class="filter-row">
            <div class="filter-chip active" data-range="all" onclick="setReportRange('all')">All Time</div>
            <div class="filter-chip" data-range="daily" onclick="setReportRange('daily')">Daily</div>
            <div class="filter-chip" data-range="monthly" onclick="setReportRange('monthly')">Monthly</div>
            <div class="filter-chip" data-range="yearly" onclick="setReportRange('yearly')">Yearly</div>
            <div class="filter-chip" data-range="tc" onclick="setReportTypeFilter('tc')">TC Only</div>
            <div class="filter-chip" data-range="bona" onclick="setReportTypeFilter('bona')">Bonafide Only</div>
            <button class="btn btn-outline btn-sm" style="margin-left:auto;" onclick="exportReportsCSV()">⇩ Export Report CSV</button>
          </div>
          <div class="table-card">
            <table>
              <thead>
                <tr><th>Date</th><th>Time</th><th>Type</th><th>Student</th><th>Admission No.</th><th id="issuedByHeader">Issued By</th></tr>
              </thead>
              <tbody id="reportsBody"></tbody>
            </table>
            <div class="empty-state" id="reportsEmptyState" style="display:none;">
              <h3>No records yet</h3><p>Certificates you generate will be logged here.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ============ PAGE: BACKUP ============ -->
      <div class="page" id="page-backup">
        <div class="topbar-slim">
          <div><h2 class="page-title">Backup</h2><p class="page-sub">Keep a safe zip copy of all student, certificate and report data.</p></div>
        </div>
        <div class="container">
          <div class="backup-card">
            <h3>Backup Folder</h3>
            <p>Choose a folder on your computer (e.g. a folder on your D: drive) where backups should be saved. Your browser will remember it for this device. <b>Note:</b> the backup zip includes login usernames/passwords, so keep it somewhere private.</p>
            <div class="backup-status" id="backupFolderStatus"><span class="dot"></span><span id="backupFolderText">No backup folder selected yet.</span></div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
              <button class="btn btn-primary" onclick="chooseBackupFolder()">📁 Choose Backup Folder</button>
              <button class="btn btn-brass" onclick="runBackupNow()">⇩ Backup Now</button>
            </div>
          </div>
          <div class="backup-card">
            <h3>Email Backup</h3>
            <p>Downloads the backup zip to your device, then opens Gmail with the "To" and "Subject" already filled in — you just attach the file that was downloaded (using the 📎 button in Gmail) and hit Send. Set your backup email once in <b>Settings → Email Backup Settings</b>.</p>
            <div class="backup-status" id="emailBackupStatus"><span class="dot"></span><span id="emailBackupStatusText">Not configured yet — set this up in Settings.</span></div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
              <button class="btn btn-outline" onclick="emailBackupNow()">✉ Email Backup Now</button>
            </div>
          </div>
          <div class="backup-card">
            <h3>Restore on a New Computer</h3>
            <p>This app stores everything (logins, students, settings) only inside <b>this specific browser on this specific computer</b> — nothing is synced to the cloud. If you open this same HTML file on a different PC, it starts empty and the login resets to the defaults (<b>admin / admin123</b>). To bring your real data over, take a backup zip from the old computer (button above) and restore it here.</p>
            <div class="backup-status" id="restoreStatus"><span class="dot"></span><span id="restoreStatusText">No backup restored yet on this device.</span></div>
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
              <input type="file" id="restoreFileInput" accept=".zip" style="display:none" onchange="handleRestoreFile(this)">
              <button class="btn btn-outline" onclick="document.getElementById('restoreFileInput').click()">📤 Restore from Backup Zip</button>
            </div>
          </div>
          <div class="backup-card">
            <h3>Automatic Daily Backup</h3>
            <p>When enabled, the system checks each time this app is opened whether today's backup has been made — if not, it saves one automatically to your chosen folder.</p>
            <label class="switch-row"><input type="checkbox" id="autoBackupToggle" onchange="toggleAutoBackup(this.checked)"> Enable automatic daily backup on open</label>
            <div class="backup-status" id="lastBackupStatus"><span class="dot"></span><span id="lastBackupText">No backup has been made yet.</span></div>
            <div class="note-box">
              ⚠ <b>Browser limitation:</b> a web page cannot silently write files to your D: drive without your permission, and it can only run while this app is open in a supported browser (Chrome or Edge on desktop). It cannot run in the background if the browser is fully closed. For true unattended daily backups (even when the app isn't open), ask your IT staff to set up a Windows Task Scheduler job, or simply open this app once a day — the automatic check above will then run the backup for you.
            </div>
          </div>
        </div>
      </div>

      <!-- ============ PAGE: SETTINGS ============ -->
      <div class="page" id="page-settings">
        <div class="topbar-slim">
          <div><h2 class="page-title">Settings</h2><p class="page-sub">Institution letterhead and user accounts.</p></div>
        </div>
        <div class="container">
          <div class="settings-tabs">
            <div class="settings-tab-btn active" data-tab="inst" onclick="showSettingsTab('inst')">Institution</div>
            <div class="settings-tab-btn" data-tab="users" onclick="showSettingsTab('users')" id="usersTabBtn">Users <span class="role-badge admin">Admin</span></div>
          </div>

          <div class="settings-pane active" id="settingsPane-inst">
            <div class="backup-card">
              <div class="form-grid">
                <div class="field full"><label>College Name</label><input id="s_collegeName"></div>
                <div class="field full"><label>Address</label><input id="s_address"></div>
                <div class="field full"><label>Approval / Affiliation Line</label><input id="s_approval"></div>
                <div class="field"><label>Phone</label><input id="s_phone"></div>
                <div class="field"><label>Email</label><input id="s_email"></div>
                <div class="field"><label>Principal Name</label><input id="s_principalName" placeholder="Mr. JEEVANANTHAM V.,M.E"></div>
                <div class="field"><label>Principal Title</label><input id="s_principalTitle" placeholder="Principal"></div>
                <div class="field full">
                  <label>College Logo / Seal <span class="hint">(shown on certificates — saved automatically once uploaded)</span></label>
                  <div style="display:flex; align-items:center; gap:14px; margin-bottom:8px;">
                    <div id="logoPreviewWrap" style="width:64px;height:64px;border-radius:50%;border:2px solid var(--line);overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f6f7fa;flex-shrink:0;">
                      <img id="logoPreviewImg" src="" alt="Logo preview" style="width:100%;height:100%;object-fit:cover;display:none;">
                      <span id="logoPreviewPlaceholder" style="font-size:10px;color:var(--muted);">No logo</span>
                    </div>
                    <div style="flex:1;">
                      <input type="file" id="s_logo" accept="image/*" onchange="previewLogoFile(this)">
                      <div style="margin-top:6px;"><button type="button" class="btn btn-danger-outline btn-sm" onclick="removeLogo()">Remove Logo</button></div>
                    </div>
                  </div>
                </div>
              </div>
              <div style="margin-top:16px;"><button class="btn btn-primary" onclick="saveSettings()">Save Institution Settings</button></div>
            </div>

            <div class="backup-card">
              <h3>Email Backup Settings</h3>
              <p>Fill in the email address you want backups sent to. Clicking "Email Backup Now" on the Backup page will download the backup zip and open Gmail with this address and a subject already filled in — you then attach the downloaded file and send. No account, no fees, no setup beyond this.</p>
              <div class="form-grid">
                <div class="field full"><label>Send Backup To (Email Address)</label><input id="s_backupEmail" placeholder="you@gmail.com"></div>
              </div>
              <div style="margin-top:16px;"><button class="btn btn-primary" onclick="saveSettings()">Save Email Backup Settings</button></div>
            </div>
          </div>

          <div class="settings-pane" id="settingsPane-users">
            <div class="backup-card">
              <h3>User Accounts</h3>
              <p>Admins can create staff logins, reset passwords, and remove accounts. Staff cannot access this tab.</p>
              <div id="usersList"></div>
              <div class="form-grid" style="margin-top:16px;">
                <div class="field"><label>Username</label><input id="nu_username"></div>
                <div class="field"><label>Full Name</label><input id="nu_name"></div>
                <div class="field"><label>Password</label><input id="nu_password" type="text"></div>
                <div class="field"><label>Role</label>
                  <select id="nu_role"><option value="staff">Staff</option><option value="admin">Admin</option></select>
                </div>
              </div>
              <div style="margin-top:12px;"><button class="btn btn-brass" onclick="addUser()">+ Add User</button></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- ============ Add / Edit Student Modal ============ -->
  <div class="modal-overlay" id="studentModalOverlay">
    <div class="modal modal-lg">
      <div class="modal-head">
        <div><h2 id="studentModalTitle">Add Student</h2><p>Shared record used for both Transfer Certificate and Bonafide Certificate.</p></div>
        <button class="modal-close" onclick="closeModal('studentModalOverlay')">✕</button>
      </div>
      <div class="modal-body">
        <form id="studentForm" class="form-grid" onsubmit="return false;">
          <input type="hidden" id="f_id">
          <div class="section-label first">Identification</div>
          <div class="field"><label>Sl. No.</label><input id="f_slNo"></div>
          <div class="field"><label>Admission No.</label><input id="f_admissionNo"></div>
          <div class="field"><label>UMIS ID</label><input id="f_umisId"></div>
          <div class="field"><label>Register No.</label><input id="f_regNo"></div>
          <div class="field full"><label>1. Name of the Student</label><input id="f_name"></div>
          <div class="field full"><label>2. Name of the Father / Guardian</label><input id="f_fatherName"></div>

          <div class="section-label">Personal Details</div>
          <div class="field"><label>Nationality</label><input id="f_nationality" value="INDIAN"></div>
          <div class="field"><label>Religion</label><input id="f_religion" placeholder="HINDU"></div>
          <div class="field full"><label>3. Community & Caste <span class="hint">as it should print</span></label><input id="f_communityCaste" placeholder="Refer Community Certificate, Issued by Revenue Authorities"></div>
          <div class="field"><label>4. Sex</label>
            <select id="f_sex"><option value="MALE">MALE</option><option value="FEMALE">FEMALE</option><option value="OTHER">OTHER</option></select>
          </div>
          <div class="field"><label>5. Date of Birth</label><input type="date" id="f_dob"></div>

          <div class="section-label">Admission &amp; Course (Transfer Certificate)</div>
          <div class="field"><label>6. Date of Admission</label><input type="date" id="f_dateOfAdmission"></div>
          <div class="field"><label>7. Medium of Study</label><input id="f_medium" value="ENGLISH"></div>
          <div class="field full"><label>8. Class in which studying at time of leaving</label><input id="f_classAtLeaving" placeholder="Diploma in MECHANICAL ENGINEERING - III YEAR - VI SEMESTER"></div>
          <div class="field full"><label>9. Whether qualified for promotion</label><input id="f_promotion" placeholder="REFER THE MARK SHEET"></div>

          <div class="section-label">Leaving Details (Transfer Certificate)</div>
          <div class="field"><label>10. Date student left college</label><input type="date" id="f_dateOfLeaving"></div>
          <div class="field"><label>11. Reason for leaving</label><input id="f_reason" placeholder="COURSE COMPLETED"></div>
          <div class="field"><label>12. Date TC application made</label><input type="date" id="f_dateOfApplication"></div>
          <div class="field"><label>Date of Issue</label><input type="date" id="f_dateOfIssue"></div>
          <div class="field full"><label>13. Conduct and character of the student</label><input id="f_conduct" placeholder="GOOD"></div>

          <div class="section-label">Bonafide Certificate Details</div>
          <div class="field"><label>Currently Studying Year</label>
            <select id="f_currentYear"><option value="I">I Year</option><option value="II">II Year</option><option value="III">III Year</option><option value="IV">IV Year</option></select>
          </div>
          <div class="field full"><label>Course / Branch <span class="hint">as it should print in Bonafide</span></label><input id="f_branch" placeholder="DIPLOMA IN ELECTRICAL AND ELECTRONICS ENGINEERING"></div>
          <div class="field"><label>Academic Year From</label><input id="f_acadFrom" placeholder="2026"></div>
          <div class="field"><label>Academic Year To</label><input id="f_acadTo" placeholder="2027"></div>
          <div class="field"><label>Admitted to Institution In</label><input id="f_admissionYear" placeholder="2026"></div>
        </form>
      </div>
      <div class="modal-foot">
        <button class="btn btn-outline" onclick="closeModal('studentModalOverlay')">Cancel</button>
        <button class="btn btn-primary" onclick="saveStudent()">Save Student</button>
      </div>
    </div>
  </div>

  <!-- ============ Student Detail Modal ============ -->
  <div class="modal-overlay" id="detailModalOverlay">
    <div class="modal modal-lg">
      <div class="modal-head">
        <div><h2 id="detailName">Student Name</h2><p id="detailSub">Admission No. —</p></div>
        <button class="modal-close" onclick="closeModal('detailModalOverlay')">✕</button>
      </div>
      <div class="modal-body"><div class="detail-grid" id="detailGrid"></div></div>
      <div class="modal-foot">
        <div class="left-actions">
          <button class="btn btn-danger-outline" onclick="deleteFromDetail()">🗑 Delete</button>
          <button class="btn btn-outline" onclick="editFromDetail()">✎ Edit</button>
        </div>
        <button class="btn btn-outline" onclick="closeModal('detailModalOverlay')">Close</button>
        <button class="btn btn-outline" onclick="startVerify('TC', selectedStudentId)">🎓 Transfer Certificate</button>
        <button class="btn btn-brass" onclick="startVerify('BONAFIDE', selectedStudentId)">📜 Bonafide Certificate</button>
      </div>
    </div>
  </div>

  <!-- ============ Bulk Import Modal (Admin only) ============ -->
  <div class="modal-overlay" id="importModalOverlay">
    <div class="modal">
      <div class="modal-head">
        <div><h2>Bulk Import Students</h2><p>Download the template, fill it in Excel/Sheets, then upload it back as CSV.</p></div>
        <button class="modal-close" onclick="closeModal('importModalOverlay')">✕</button>
      </div>
      <div class="modal-body">
        <div class="steps">
          <div class="step-box">
            <div class="step-num">1</div>
            <div><h4>Download the CSV template</h4><p>Includes column headers and one filled example row.</p>
              <button class="btn btn-outline btn-sm" onclick="downloadTemplate()">⇩ Download Template (.csv)</button>
            </div>
          </div>
          <div class="step-box">
            <div class="step-num">2</div>
            <div style="width:100%;">
              <h4>Upload your filled CSV</h4><p>One row per student. Dates should be in YYYY-MM-DD format.</p>
              <div class="drop-zone" id="dropZone" onclick="document.getElementById('csvFileInput').click()">📄 Click to choose a CSV file, or drag it here</div>
              <input type="file" id="csvFileInput" accept=".csv,text/csv">
              <div class="import-summary" id="importSummary"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-foot"><button class="btn btn-outline" onclick="closeModal('importModalOverlay')">Close</button></div>
    </div>
  </div>

  <!-- ============ Verify Before Generate Modal ============ -->
  <div class="modal-overlay" id="verifyModalOverlay">
    <div class="modal">
      <div class="modal-head">
        <div><h2 id="verifyTitle">Verify Before Issuing</h2><p id="verifySub">Please confirm the details below are correct.</p></div>
        <button class="modal-close" onclick="closeModal('verifyModalOverlay')">✕</button>
      </div>
      <div class="modal-body">
        <div class="form-grid">
          <div class="field full"><label>Student</label><input id="v_studentLabel" disabled></div>
          <div class="field"><label>Date of Issue</label><input type="date" id="v_dateOfIssue"></div>
          <div class="field full" id="v_purposeField"><label>Purpose <span class="hint">(Bonafide only)</span></label><input id="v_purpose" placeholder="Scholarship"></div>
        </div>
        <label style="display:flex; align-items:flex-start; gap:10px; margin-top:16px; font-size:13px; color:var(--navy); font-weight:600;">
          <input type="checkbox" id="v_confirmCheck" style="margin-top:3px;">
          I have verified the student's details above and confirm this certificate should be issued now.
        </label>
      </div>
      <div class="modal-foot">
        <button class="btn btn-outline" onclick="closeModal('verifyModalOverlay')">Cancel</button>
        <button class="btn btn-brass" id="verifyConfirmBtn" onclick="confirmVerifyAndGenerate()">Verify &amp; Generate</button>
      </div>
    </div>
  </div>

  <!-- ============ Certificate Modal (shared by TC + Bonafide) ============ -->
  <div class="modal-overlay" id="certModalOverlay">
    <div class="modal modal-lg" style="max-width:840px;">
      <div class="modal-head">
        <div><h2 id="certModalTitle">Certificate</h2><p id="certSub">Preview — matches the official college format</p></div>
        <button class="modal-close" onclick="closeModal('certModalOverlay')">✕</button>
      </div>
      <div class="cert-toolbar">
        <span style="font-size:12.5px;color:#6b7280;">Ready to download, print, or save — this generation has been logged to Reports</span>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <button class="btn btn-outline btn-sm" onclick="printCertificate()">🖨 Print</button>
          <button class="btn btn-brass btn-sm" onclick="downloadCertificatePDF()">⇩ Download PDF</button>
        </div>
      </div>
      <div class="cert-scroll"><div id="certPrintArea"></div></div>
    </div>
  </div>

  <div class="toast" id="toast"></div>

<script>
/* ======================================================================
   LOCAL STORAGE KEYS
   ====================================================================== */
const LS_USERS = 'cs_users';
const LS_SESSION = 'cs_session';
const LS_STUDENTS = 'cs_students';
const LS_SETTINGS = 'cs_settings';
const LS_REPORTS = 'cs_reports';
const LS_AUTOBACKUP = 'cs_autobackup';
const LS_LASTBACKUP = 'cs_lastbackup';

/* ======================================================================
   BACKEND (PHP + MySQL) CONNECTION
   Change this if your XAMPP folder has a different name or the server
   is hosted elsewhere, e.g. 'http://192.168.1.5/cert-backend'
   ====================================================================== */
const BACKEND_URL = 'http://localhost/cert-backend';
let backendOnline = false;

async function apiGet(path){
  const res = await fetch(`${BACKEND_URL}/${path}`);
  if(!res.ok) throw new Error('Request failed: ' + path);
  return res.json();
}
async function apiPost(path, body){
  const res = await fetch(`${BACKEND_URL}/${path}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body)
  });
  if(!res.ok) throw new Error('Request failed: ' + path);
  return res.json();
}

// Fire-and-forget: push the full current array to MySQL. Silently does
// nothing if the backend isn't reachable — localStorage still has the data.
function syncStudentsToBackend(){ apiPost('api/students.php?action=sync', { students }).then(()=>{backendOnline=true; updateBackendStatusUI();}).catch(()=>{backendOnline=false; updateBackendStatusUI();}); }
function syncReportsToBackend(){ apiPost('api/reports.php?action=sync', { reports }).catch(()=>{}); }
function syncUsersToBackend(){ apiPost('api/users.php?action=sync', { users }).catch(()=>{}); }
function syncSettingsToBackend(){ apiPost('api/settings.php', settings).catch(()=>{}); }

function updateBackendStatusUI(){
  const el = document.getElementById('backendStatusDot');
  if(!el) return;
  el.style.background = backendOnline ? '#1a7a3c' : '#b3261e';
  el.title = backendOnline ? 'Connected to MySQL backend' : 'Backend not reachable — using browser storage only';
}

/* ======================================================================
   STATE
   ====================================================================== */
let currentUser = null;
let users = [];
let settings = { collegeName:"SBM POLYTECHNIC COLLEGE", address:"SBM NAGAR, TRICHY ROAD, THAMARAIPADI (PO), DINDIGUL - 5",
  approval:"(APPROVED BY AICTE NEW DELHI & DIRECTORATE OF TECHNICAL EDUCATION, TAMILNADU)",
  phone:"0451-2051943", email:"538sbm@gmail.com", principalName:"Mr. JEEVANANTHAM V.,M.E", principalTitle:"Principal",
  logoDataUrl:null, backupEmail:"" };
let students = [];
let reports = [];
let selectedStudentId = null;
let pendingGenerate = null; // { type: 'TC'|'BONAFIDE', studentId }
let currentCertType = null;
let currentCertStudent = null;
let reportRangeFilter = 'all';
let reportTypeFilter = null; // 'tc' | 'bona' | null

function cryptoId(prefix){ return (prefix||'id') + '_' + Math.random().toString(36).slice(2,10) + Date.now().toString(36); }

/* ======================================================================
   PERSISTENCE
   ====================================================================== */
async function loadAll(){
  // Load from browser storage first so the app can render immediately.
  try{ const u = localStorage.getItem(LS_USERS); users = u ? JSON.parse(u) : defaultUsers(); }catch(e){ users = defaultUsers(); }
  if(!users || users.length === 0) users = defaultUsers();
  try{ const s = localStorage.getItem(LS_SETTINGS); if(s) settings = Object.assign(settings, JSON.parse(s)); }catch(e){}
  try{ const st = localStorage.getItem(LS_STUDENTS); students = st ? JSON.parse(st) : seedStudents(); }catch(e){ students = seedStudents(); }
  try{ const r = localStorage.getItem(LS_REPORTS); reports = r ? JSON.parse(r) : []; }catch(e){ reports = []; }

  // Then try the MySQL backend — if it answers, its data wins (source of truth).
  try{
    const [bu, bs, bst, br] = await Promise.all([
      apiGet('api/users.php'),
      apiGet('api/settings.php'),
      apiGet('api/students.php'),
      apiGet('api/reports.php'),
    ]);
    if(Array.isArray(bu) && bu.length) users = bu;
    if(bs && bs.collegeName) settings = Object.assign(settings, bs);
    if(Array.isArray(bst)) students = bst;
    if(Array.isArray(br)) reports = br;
    backendOnline = true;
  }catch(e){
    backendOnline = false; // XAMPP not running / backend not reachable — keep using browser storage
  }

  saveUsers(); saveStudents(); saveReports(); saveSettingsLS();
  updateBackendStatusUI();
}
function defaultUsers(){
  return [
    { username:'admin', password:'admin123', role:'admin', name:'Administrator' },
    { username:'staff', password:'staff123', role:'staff', name:'Staff Member' }
  ];
}
function seedStudents(){
  return [
    { id: cryptoId('stu'), slNo:"124", admissionNo:"24124", umisId:"1016332907", regNo:"24207935",
      name:"MOHAN T", fatherName:"THANGAPANDI C", nationality:"INDIAN", religion:"HINDU",
      communityCaste:"Refer Community Certificate, Issued by Revenue Authorities", sex:"MALE",
      dob:"2007-07-18", dateOfAdmission:"2023-07-03", medium:"ENGLISH",
      classAtLeaving:"Diploma in MECHANICAL ENGINEERING - III YEAR - VI SEMESTER",
      promotion:"REFER THE MARK SHEET", dateOfLeaving:"2026-04-16", reason:"COURSE COMPLETED",
      dateOfApplication:"2026-04-16", dateOfIssue:"2026-04-17", conduct:"GOOD",
      currentYear:"III", branch:"DIPLOMA IN MECHANICAL ENGINEERING", acadFrom:"2023", acadTo:"2026", admissionYear:"2023" }
  ];
}
function saveUsers(){ localStorage.setItem(LS_USERS, JSON.stringify(users)); syncUsersToBackend(); }
function saveSettingsLS(){ localStorage.setItem(LS_SETTINGS, JSON.stringify(settings)); syncSettingsToBackend(); }
function saveStudents(){ localStorage.setItem(LS_STUDENTS, JSON.stringify(students)); syncStudentsToBackend(); }
function saveReports(){ localStorage.setItem(LS_REPORTS, JSON.stringify(reports)); syncReportsToBackend(); }

/* ======================================================================
   AUTH
   ====================================================================== */
function handleLogin(e){
  e.preventDefault();
  const u = document.getElementById('li_username').value.trim();
  const p = document.getElementById('li_password').value;
  const match = users.find(x => x.username.toLowerCase() === u.toLowerCase() && x.password === p);
  const err = document.getElementById('loginError');
  if(!match){ err.classList.add('show'); return false; }
  err.classList.remove('show');
  currentUser = match;
  sessionStorage.setItem(LS_SESSION, JSON.stringify({ username: match.username }));
  enterApp();
  return false;
}
function handleLogout(){
  currentUser = null;
  sessionStorage.removeItem(LS_SESSION);
  document.getElementById('appShell').classList.remove('active');
  document.getElementById('loginOverlay').style.display = 'flex';
  document.getElementById('loginForm').reset();
}
function tryRestoreSession(){
  try{
    const s = sessionStorage.getItem(LS_SESSION);
    if(!s) return false;
    const parsed = JSON.parse(s);
    const match = users.find(x => x.username === parsed.username);
    if(!match) return false;
    currentUser = match;
    return true;
  }catch(e){ return false; }
}
function enterApp(){
  document.getElementById('loginOverlay').style.display = 'none';
  document.getElementById('appShell').classList.add('active');
  document.getElementById('sbUserName').textContent = currentUser.name;
  document.getElementById('sbUserRole').textContent = currentUser.role;
  document.getElementById('sbUserAvatar').textContent = (currentUser.name||'?').slice(0,1).toUpperCase();
  applySettingsToHeader();
  applyRoleVisibility();
  goPage('dashboard');
  renderTable(); renderTCList(); renderBonaList(); renderReports(); renderUsersList(); populateSettingsForm();
  checkAutoBackupOnOpen();
}
function applyRoleVisibility(){
  const isAdmin = currentUser.role === 'admin';
  document.getElementById('adminOnlyImportExport').style.display = isAdmin ? 'flex' : 'none';
  document.getElementById('usersTabBtn').style.display = isAdmin ? 'inline-block' : 'none';
  document.getElementById('issuedByHeader').style.display = isAdmin ? '' : 'none';
}

/* ======================================================================
   NAVIGATION
   ====================================================================== */
function goPage(name){
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  const page = document.getElementById('page-' + name);
  if(page) page.classList.add('active');
  const nav = document.querySelector('.nav-item[data-page="' + name + '"]');
  if(nav) nav.classList.add('active');
  if(name === 'reports') renderReports();
  if(name === 'settings') { populateSettingsForm(); renderUsersList(); }
  if(name === 'dashboard') renderTable();
  if(name === 'tc') renderTCList();
  if(name === 'bonafide') renderBonaList();
}

/* ======================================================================
   INIT
   ====================================================================== */
document.addEventListener('DOMContentLoaded', async () => {
  await loadAll();
  document.getElementById('csvFileInput').addEventListener('change', handleCSVFile);
  const dz = document.getElementById('dropZone');
  ['dragover','dragenter'].forEach(evt => dz.addEventListener(evt, e => { e.preventDefault(); dz.classList.add('drag'); }));
  ['dragleave','drop'].forEach(evt => dz.addEventListener(evt, e => { e.preventDefault(); dz.classList.remove('drag'); }));
  dz.addEventListener('drop', e => { if(e.dataTransfer.files && e.dataTransfer.files[0]) parseCSVFile(e.dataTransfer.files[0]); });

  document.getElementById('loginCollegeName').textContent = settings.collegeName;
  document.getElementById('loginBrandMark').textContent = brandInitials();

  document.getElementById('autoBackupToggle').checked = localStorage.getItem(LS_AUTOBACKUP) === 'true';
  refreshLastBackupStatus();
  refreshBackupFolderStatus();
  refreshEmailBackupStatus();

  if(tryRestoreSession()) enterApp();
});

/* ======================================================================
   TOAST
   ====================================================================== */
let toastTimer = null;
function showToast(msg, type){
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast show ' + (type || '');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => { t.className = 'toast ' + (type || ''); }, 2600);
}

/* ======================================================================
   MODAL HELPERS
   ====================================================================== */
function openModal(id){ document.getElementById(id).classList.add('open'); }
function closeModal(id){ document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(ov => {
  ov.addEventListener('click', e => { if(e.target === ov) closeModal(ov.id); });
});

function escapeHtml(str){
  return String(str ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
}
function brandInitials(){
  return (settings.collegeName||'').split(' ').map(w=>w[0]).slice(0,3).join('').toUpperCase();
}

/* ======================================================================
   DASHBOARD TABLE RENDER + SEARCH
   ====================================================================== */
function renderTable(){
  const q = (document.getElementById('searchInput').value || '').trim().toLowerCase();
  const filtered = students.filter(s => {
    if(!q) return true;
    return (s.name||'').toLowerCase().includes(q) || (s.admissionNo||'').toLowerCase().includes(q)
        || (s.regNo||'').toLowerCase().includes(q) || (s.umisId||'').toLowerCase().includes(q);
  });

  document.getElementById('countPill').textContent = students.length + ' student' + (students.length===1?'':'s') +
    (q ? ` · ${filtered.length} match${filtered.length===1?'':'es'}` : '');

  document.getElementById('statTotalStudents').textContent = students.length;
  document.getElementById('statTCIssued').textContent = reports.filter(r=>r.type==='TC').length;
  document.getElementById('statBonaIssued').textContent = reports.filter(r=>r.type==='BONAFIDE').length;
  const todayStr = new Date().toDateString();
  document.getElementById('statToday').textContent = reports.filter(r => new Date(r.timestamp).toDateString() === todayStr).length;

  const tbody = document.getElementById('tableBody');
  const empty = document.getElementById('emptyState');
  if(filtered.length === 0){
    tbody.innerHTML = ''; empty.style.display = 'block';
    empty.querySelector('h3').textContent = q ? 'No matches' : 'No students found';
    empty.querySelector('p').textContent = q ? `No student matches "${q}".` : 'Add a student manually or bulk-import a CSV file to get started.';
    return;
  }
  empty.style.display = 'none';
  tbody.innerHTML = filtered.map(s => `
    <tr>
      <td><button class="stu-name" onclick="openStudentDetail('${s.id}')">${escapeHtml(s.name || '(no name)')}</button>
        <div class="stu-sub">Reg. No. ${escapeHtml(s.regNo || '—')}</div></td>
      <td>${escapeHtml(s.admissionNo || '—')}</td>
      <td>${escapeHtml(s.classAtLeaving || s.branch || '—')}</td>
      <td>${escapeHtml(s.fatherName || '—')}</td>
      <td><div class="row-actions">
        <button class="icon-btn" title="View / Generate" onclick="openStudentDetail('${s.id}')">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
        <button class="icon-btn" title="Edit" onclick="openStudentModal('${s.id}')">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg></button>
        <button class="icon-btn danger" title="Delete" onclick="deleteStudent('${s.id}')">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg></button>
      </div></td>
    </tr>`).join('');
}

/* ======================================================================
   TC LIST PAGE
   ====================================================================== */
function renderTCList(){
  const q = (document.getElementById('tcSearchInput').value || '').trim().toLowerCase();
  const filtered = students.filter(s => !q || (s.name||'').toLowerCase().includes(q) || (s.admissionNo||'').toLowerCase().includes(q));
  document.getElementById('tcCountPill').textContent = filtered.length + ' student' + (filtered.length===1?'':'s');
  const tbody = document.getElementById('tcListBody');
  const empty = document.getElementById('tcEmptyState');
  if(filtered.length === 0){ tbody.innerHTML=''; empty.style.display='block'; return; }
  empty.style.display = 'none';
  tbody.innerHTML = filtered.map(s => `
    <tr><td><b style="color:var(--navy)">${escapeHtml(s.name||'(no name)')}</b><div class="stu-sub">Reg. No. ${escapeHtml(s.regNo||'—')}</div></td>
      <td>${escapeHtml(s.admissionNo||'—')}</td>
      <td>${escapeHtml(s.classAtLeaving||'—')}</td>
      <td style="text-align:right;"><button class="gen-btn" onclick="startVerify('TC','${s.id}')">Generate TC</button></td></tr>`).join('');
}

/* ======================================================================
   BONAFIDE LIST PAGE
   ====================================================================== */
function renderBonaList(){
  const q = (document.getElementById('bonaSearchInput').value || '').trim().toLowerCase();
  const filtered = students.filter(s => !q || (s.name||'').toLowerCase().includes(q) || (s.admissionNo||'').toLowerCase().includes(q));
  document.getElementById('bonaCountPill').textContent = filtered.length + ' student' + (filtered.length===1?'':'s');
  const tbody = document.getElementById('bonaListBody');
  const empty = document.getElementById('bonaEmptyState');
  if(filtered.length === 0){ tbody.innerHTML=''; empty.style.display='block'; return; }
  empty.style.display = 'none';
  tbody.innerHTML = filtered.map(s => `
    <tr><td><b style="color:var(--navy)">${escapeHtml(s.name||'(no name)')}</b><div class="stu-sub">Reg. No. ${escapeHtml(s.regNo||'—')}</div></td>
      <td>${escapeHtml(s.admissionNo||'—')}</td>
      <td>${escapeHtml((s.currentYear?s.currentYear+' Year — ':'') + (s.branch||'—'))}</td>
      <td style="text-align:right;"><button class="gen-btn" onclick="startVerify('BONAFIDE','${s.id}')">Generate Bonafide</button></td></tr>`).join('');
}

/* ======================================================================
   ADD / EDIT STUDENT
   ====================================================================== */
const formFieldMap = {
  slNo:'f_slNo', admissionNo:'f_admissionNo', umisId:'f_umisId', regNo:'f_regNo',
  name:'f_name', fatherName:'f_fatherName', nationality:'f_nationality', religion:'f_religion',
  communityCaste:'f_communityCaste', sex:'f_sex', dob:'f_dob', dateOfAdmission:'f_dateOfAdmission',
  medium:'f_medium', classAtLeaving:'f_classAtLeaving', promotion:'f_promotion',
  dateOfLeaving:'f_dateOfLeaving', reason:'f_reason', dateOfApplication:'f_dateOfApplication',
  dateOfIssue:'f_dateOfIssue', conduct:'f_conduct',
  currentYear:'f_currentYear', branch:'f_branch', acadFrom:'f_acadFrom', acadTo:'f_acadTo', admissionYear:'f_admissionYear'
};

function getNextSlNo(){
  let max = 0;
  students.forEach(s => { const n = parseInt(s.slNo, 10); if(!isNaN(n) && n > max) max = n; });
  return String(max + 1 || 1);
}

function openStudentModal(id){
  document.getElementById('studentForm').reset();
  document.getElementById('f_id').value = '';
  document.getElementById('f_nationality').value = 'INDIAN';
  document.getElementById('f_medium').value = 'ENGLISH';
  document.getElementById('f_slNo').value = getNextSlNo();

  if(id){
    const s = students.find(x => x.id === id);
    if(!s) return;
    document.getElementById('studentModalTitle').textContent = 'Edit Student';
    document.getElementById('f_id').value = s.id;
    Object.keys(formFieldMap).forEach(key => {
      const el = document.getElementById(formFieldMap[key]);
      if(el) el.value = s[key] || (key==='nationality' ? 'INDIAN' : key==='medium' ? 'ENGLISH' : '');
    });
  } else {
    document.getElementById('studentModalTitle').textContent = 'Add Student';
  }
  closeModal('detailModalOverlay');
  openModal('studentModalOverlay');
}

function saveStudent(){
  const name = document.getElementById('f_name').value.trim();
  const admissionNo = document.getElementById('f_admissionNo').value.trim();
  if(!name || !admissionNo){ showToast('Name and Admission No. are required', 'error'); return; }
  const id = document.getElementById('f_id').value;
  const data = { id: id || cryptoId('stu') };
  Object.keys(formFieldMap).forEach(key => {
    const el = document.getElementById(formFieldMap[key]);
    data[key] = el ? el.value.trim() : '';
  });
  if(!data.slNo) data.slNo = getNextSlNo();

  if(id){
    const idx = students.findIndex(s => s.id === id);
    if(idx > -1) students[idx] = data;
    showToast('Student updated', 'success');
  } else {
    students.push(data);
    showToast('Student added', 'success');
  }
  saveStudents();
  closeModal('studentModalOverlay');
  renderTable(); renderTCList(); renderBonaList();
}

function deleteStudent(id){
  const s = students.find(x => x.id === id);
  if(!s) return;
  if(!confirm(`Delete ${s.name}'s record? This cannot be undone.`)) return;
  students = students.filter(x => x.id !== id);
  saveStudents();
  showToast('Student deleted', 'success');
  renderTable(); renderTCList(); renderBonaList();
}

/* ======================================================================
   STUDENT DETAIL VIEW
   ====================================================================== */
function openStudentDetail(id){
  const s = students.find(x => x.id === id);
  if(!s) return;
  selectedStudentId = id;
  document.getElementById('detailName').textContent = s.name || '(no name)';
  document.getElementById('detailSub').textContent = `Admission No. ${s.admissionNo || '—'} · Reg. No. ${s.regNo || '—'}`;
  const rows = [
    ['Sl. No.', s.slNo], ['Admission No.', s.admissionNo], ['UMIS ID', s.umisId], ['Reg. No.', s.regNo],
    ["Father's / Guardian's Name", s.fatherName], ['Nationality', s.nationality], ['Religion', s.religion],
    ['Community & Caste', s.communityCaste], ['Sex', s.sex], ['Date of Birth', formatDate(s.dob)],
    ['Date of Admission', formatDate(s.dateOfAdmission)], ['Medium of Study', s.medium],
    ['Class at Leaving', s.classAtLeaving], ['Promotion Status', s.promotion],
    ['Date of Leaving', formatDate(s.dateOfLeaving)], ['Reason for Leaving', s.reason],
    ['TC Application Date', formatDate(s.dateOfApplication)], ['Date of Issue (TC)', formatDate(s.dateOfIssue)],
    ['Conduct & Character', s.conduct], ['Bonafide: Current Year', s.currentYear],
    ['Bonafide: Branch', s.branch], ['Bonafide: Academic Year', (s.acadFrom&&s.acadTo)?`${s.acadFrom} to ${s.acadTo}`:''],
    ['Bonafide: Admitted In', s.admissionYear]
  ];
  document.getElementById('detailGrid').innerHTML = rows.map(([k,v]) => `
    <div class="detail-item"><div class="k">${escapeHtml(k)}</div><div class="v">${escapeHtml(v || '—')}</div></div>`).join('');
  openModal('detailModalOverlay');
}
function editFromDetail(){ if(selectedStudentId) openStudentModal(selectedStudentId); }
function deleteFromDetail(){ if(selectedStudentId){ closeModal('detailModalOverlay'); deleteStudent(selectedStudentId); } }

/* ======================================================================
   VERIFY -> GENERATE FLOW (with reporting)
   ====================================================================== */
function startVerify(type, studentId){
  const s = students.find(x => x.id === studentId);
  if(!s){ showToast('Student not found', 'error'); return; }
  pendingGenerate = { type, studentId };
  document.getElementById('verifyTitle').textContent = 'Verify Before Issuing ' + (type === 'TC' ? 'Transfer Certificate' : 'Bonafide Certificate');
  document.getElementById('v_studentLabel').value = `${s.name} — Admission No. ${s.admissionNo || '—'}`;
  document.getElementById('v_dateOfIssue').value = (type === 'TC' ? s.dateOfIssue : '') || new Date().toISOString().slice(0,10);
  document.getElementById('v_purpose').value = 'Scholarship';
  document.getElementById('v_purposeField').style.display = type === 'BONAFIDE' ? 'block' : 'none';
  document.getElementById('v_confirmCheck').checked = false;
  closeModal('detailModalOverlay');
  openModal('verifyModalOverlay');
}

function confirmVerifyAndGenerate(){
  if(!document.getElementById('v_confirmCheck').checked){
    showToast('Please confirm you have verified the details first', 'error');
    return;
  }
  if(!pendingGenerate) return;
  const s = students.find(x => x.id === pendingGenerate.studentId);
  if(!s) return;
  const dateOfIssue = document.getElementById('v_dateOfIssue').value || new Date().toISOString().slice(0,10);
  const purpose = document.getElementById('v_purpose').value.trim() || 'Scholarship';

  closeModal('verifyModalOverlay');

  if(pendingGenerate.type === 'TC'){
    s.dateOfIssue = dateOfIssue;
    saveStudents();
    currentCertType = 'TC'; currentCertStudent = s;
    renderCertificateTC(s);
    document.getElementById('certModalTitle').textContent = 'Transfer Certificate';
    document.getElementById('certSub').textContent = `${s.name} · Admission No. ${s.admissionNo || '—'}`;
  } else {
    currentCertType = 'BONAFIDE'; currentCertStudent = s;
    renderCertificateBonafide(s, purpose, dateOfIssue);
    document.getElementById('certModalTitle').textContent = 'Bonafide Certificate';
    document.getElementById('certSub').textContent = `${s.name} · Admission No. ${s.admissionNo || '—'}`;
  }

  logReport(pendingGenerate.type, s, dateOfIssue);
  openModal('certModalOverlay');
  pendingGenerate = null;
}

function logReport(type, s, dateOfIssue){
  const entry = {
    id: cryptoId('rep'), type, studentId: s.id, studentName: s.name, admissionNo: s.admissionNo || '',
    issuedBy: currentUser.username, issuedByName: currentUser.name,
    dateOfIssue: dateOfIssue, timestamp: new Date().toISOString()
  };
  reports.unshift(entry);
  saveReports();
  renderReports();
}

/* ======================================================================
   DATE FORMATTING / DOB-IN-WORDS
   ====================================================================== */
function formatDate(iso){
  if(!iso) return '';
  const [y,m,d] = iso.split('-');
  if(!y||!m||!d) return iso;
  return `${d}.${m}.${y}`;
}
function formatDateLong(iso){
  if(!iso) return '';
  const [y,m,d] = iso.split('-').map(Number);
  if(!y||!m||!d) return iso;
  return `${String(d).padStart(2,'0')}-${String(m).padStart(2,'0')}-${y}`;
}
const ORDINALS = ['','First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth',
  'Eleventh','Twelfth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth',
  'Twenty-First','Twenty-Second','Twenty-Third','Twenty-Fourth','Twenty-Fifth','Twenty-Sixth','Twenty-Seventh','Twenty-Eighth','Twenty-Ninth','Thirtieth','Thirty-First'];
const MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const ONES = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
const TENS = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
function twoDigitWords(n){ if(n < 20) return ONES[n]; const t = Math.floor(n/10), o = n%10; return TENS[t] + (o ? '-' + ONES[o] : ''); }
function numberToWords(n){
  if(n === 0) return 'Zero';
  let out = '';
  if(n >= 1000){ out += ONES[Math.floor(n/1000)] + ' Thousand '; n %= 1000; }
  if(n >= 100){ out += ONES[Math.floor(n/100)] + ' Hundred '; n %= 100; }
  if(n > 0){ out += twoDigitWords(n); }
  return out.trim();
}
function dobToWords(iso){
  if(!iso) return '';
  const [y,m,d] = iso.split('-').map(Number);
  if(!y||!m||!d) return '';
  return `${ORDINALS[d]} -- ${MONTH_NAMES[m-1]} -- ${numberToWords(y)}`;
}

/* ======================================================================
   TC CERTIFICATE RENDER
   ====================================================================== */
function logoHtml(){
  return settings.logoDataUrl
    ? `<img class="cert-logo" src="${settings.logoDataUrl}" alt="College Logo">`
    : `<div class="cert-logo-placeholder">${escapeHtml(brandInitials())}</div>`;
}

function renderCertificateTC(s){
  const fields = [
    ['1','Name of the Student', s.name],
    ['2','Name of the FATHER / GUARDIAN', s.fatherName],
    ['3','Nationality, Religion, Community and Caste', [s.nationality, s.religion, s.communityCaste].filter(Boolean).join(' - ')],
    ['4','Sex', s.sex],
    ['5','Date of Birth as entered in the Admission Register (In figures & Words)', `${formatDate(s.dob)}${s.dob ? '<br>' + dobToWords(s.dob) : ''}`],
    ['6','Date of Admission', formatDate(s.dateOfAdmission)],
    ['7','Medium of Study', s.medium],
    ['8','Class in which the Student was studying at the time of leaving', s.classAtLeaving],
    ['9','Whether qualified for Promotion to a higher class', s.promotion],
    ['10','Date on which the student actually left the College', formatDate(s.dateOfLeaving)],
    ['11','Reason for leaving', s.reason],
    ['12','Date on which application for Transfer Certificate was made', formatDate(s.dateOfApplication)],
    ['13','Conduct and Character of the Student', s.conduct]
  ];
  const fieldsHtml = fields.map(([num,label,val]) => `
    <div class="cert-field"><div class="num">${num}</div><div class="label">${escapeHtml(label)}</div>
      <div class="sep">:</div><div class="val">${val ? val : '&nbsp;'}</div></div>`).join('');

  document.getElementById('certPrintArea').innerHTML = `
    <div class="cert-header">
      <div class="cert-logo-corner">${logoHtml()}</div>
      <div class="cert-header-text">
        <p class="cert-college-name">${escapeHtml(settings.collegeName)}</p>
        <p class="cert-address">${escapeHtml(settings.address)}</p>
        <p class="cert-approval">${escapeHtml(settings.approval)}</p>
      </div>
    </div>
    <hr class="cert-rule">
    <div class="cert-title">TRANSFER CERTIFICATE</div>
    <div class="cert-idrow"><span>UMIS ID : ${escapeHtml(s.umisId || '—')}</span><span>Reg. No. : ${escapeHtml(s.regNo || '—')}</span></div>
    <div class="cert-slrow"><span>Sl. No.: ${escapeHtml(s.slNo || '—')}</span><span>Admission No.: ${escapeHtml(s.admissionNo || '—')}</span></div>
    <div class="cert-fields">${fieldsHtml}</div>
  `;
}

/* ======================================================================
   BONAFIDE CERTIFICATE RENDER (matches college's printed format)
   ====================================================================== */
function pronounSet(sex){
  if(sex === 'FEMALE') return { relation:'D/O', subj:'She', poss:'her', obj:'her' };
  if(sex === 'MALE') return { relation:'S/O', subj:'He', poss:'his', obj:'him' };
  return { relation:'C/O', subj:'They', poss:'their', obj:'them' };
}

function renderCertificateBonafide(s, purpose, dateOfIssue){
  const pr = pronounSet(s.sex);
  const yearLabel = s.currentYear ? (s.currentYear + ' year') : '____ year';
  const branchLabel = s.branch || '____________________';
  const acad = (s.acadFrom && s.acadTo) ? `${s.acadFrom} to ${s.acadTo}` : '________ to ________';
  const admYear = s.admissionYear || '________';

  document.getElementById('certPrintArea').innerHTML = `
    <div class="cert-header">
      <div class="cert-logo-corner">${logoHtml()}</div>
      <div class="cert-header-text">
        <p class="cert-college-name">${escapeHtml(settings.collegeName)}</p>
        <p class="cert-address">${escapeHtml(settings.address)}</p>
        <p class="cert-contact">${settings.phone ? 'Phone: ' + escapeHtml(settings.phone) : ''}${settings.phone && settings.email ? '&nbsp;&nbsp;&nbsp;' : ''}${settings.email ? 'E-mail: ' + escapeHtml(settings.email) : ''}</p>
      </div>
    </div>
    <hr class="cert-rule">
    <div class="bona-topline">
      <div class="bona-principal">${escapeHtml(settings.principalName)}<small>${escapeHtml(settings.principalTitle)}</small></div>
      <div><b>Date: ${escapeHtml(formatDateLong(dateOfIssue))}</b></div>
    </div>
    <div class="bona-title">BONAFIDE CERTIFICATE</div>
    <div class="bona-para">
      This is to certify that <b>${escapeHtml((s.name||'').toUpperCase())}</b> ${pr.relation} <b>${escapeHtml((s.fatherName||'').toUpperCase())}</b> is a
      Bonafide student of our Polytechnic College and studying in <b>${escapeHtml(yearLabel)}</b> <b>${escapeHtml(branchLabel)}</b> branch during the
      Academic year from <b>${escapeHtml(acad)}</b>.
    </div>
    <div class="bona-para">
      ${pr.subj} was admitted to this institution on <b>${escapeHtml(admYear)}</b> and is pursuing the course regularly.
    </div>
    <div class="bona-para" style="text-indent:34px;">
      This certificate is issued on ${pr.poss} request for the purpose of <b>${escapeHtml(purpose)}</b>.
    </div>
    <div class="bona-sign-block" style="justify-content:flex-end;">
      <div class="bona-sign-text">PRINCIPAL</div>
    </div>
  `;
}

/* ======================================================================
   PRINT / DOWNLOAD
   ====================================================================== */
function printCertificate(){ window.print(); }

async function downloadCertificatePDF(){
  const s = currentCertStudent;
  const el = document.getElementById('certPrintArea');
  showToast('Preparing PDF...', '');
  try{
    const canvas = await html2canvas(el, { scale: 3, backgroundColor: '#fbf8f1' });
    const imgData = canvas.toDataURL('image/png');
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'pt', 'a4');
    const pageWidth = pdf.internal.pageSize.getWidth();   // ~595pt (A4)
    const pageHeight = pdf.internal.pageSize.getHeight(); // ~842pt (A4)
    const margin = 14; // small print margin in points
    const maxW = pageWidth - margin * 2;
    const maxH = pageHeight - margin * 2;
    const ratio = Math.min(maxW / canvas.width, maxH / canvas.height);
    const imgWidth = canvas.width * ratio;
    const imgHeight = canvas.height * ratio;
    const x = (pageWidth - imgWidth) / 2;
    const y = (pageHeight - imgHeight) / 2;
    pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
    const prefix = currentCertType === 'TC' ? 'TC' : 'Bonafide';
    const filename = `${prefix}_${(s?.name || 'student').replace(/\s+/g,'_')}_${s?.admissionNo || ''}.pdf`;
    pdf.save(filename);
    showToast('PDF downloaded', 'success');
  }catch(err){
    console.error(err);
    showToast('Could not generate PDF. Try Print instead.', 'error');
  }
}

/* ======================================================================
   INSTITUTION SETTINGS
   ====================================================================== */
function showSettingsTab(tab){
  if(tab === 'users' && currentUser.role !== 'admin'){ showToast('Only Admin can manage users', 'error'); return; }
  document.querySelectorAll('.settings-tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === tab));
  document.querySelectorAll('.settings-pane').forEach(p => p.classList.remove('active'));
  document.getElementById('settingsPane-' + tab).classList.add('active');
}

function populateSettingsForm(){
  document.getElementById('s_collegeName').value = settings.collegeName;
  document.getElementById('s_address').value = settings.address;
  document.getElementById('s_approval').value = settings.approval;
  document.getElementById('s_phone').value = settings.phone || '';
  document.getElementById('s_email').value = settings.email || '';
  document.getElementById('s_principalName').value = settings.principalName || '';
  document.getElementById('s_principalTitle').value = settings.principalTitle || '';
  document.getElementById('s_logo').value = '';
  updateLogoPreview(settings.logoDataUrl);
  document.getElementById('s_backupEmail').value = settings.backupEmail || '';
}

// Live preview as soon as a file is chosen — doesn't save until "Save Institution Settings" is clicked
function previewLogoFile(input){
  const file = input.files[0];
  if(!file) return;
  const reader = new FileReader();
  reader.onload = e => updateLogoPreview(e.target.result);
  reader.readAsDataURL(file);
}

function updateLogoPreview(dataUrl){
  const img = document.getElementById('logoPreviewImg');
  const placeholder = document.getElementById('logoPreviewPlaceholder');
  if(dataUrl){
    img.src = dataUrl; img.style.display = 'block'; placeholder.style.display = 'none';
  } else {
    img.src = ''; img.style.display = 'none'; placeholder.style.display = 'block';
  }
}

function removeLogo(){
  settings.logoDataUrl = null;
  document.getElementById('s_logo').value = '';
  updateLogoPreview(null);
  applySettingsToHeader();
  saveSettingsLS();
  showToast('Logo removed and saved', 'success');
}

function saveSettings(){
  settings.collegeName = document.getElementById('s_collegeName').value.trim() || settings.collegeName;
  settings.address = document.getElementById('s_address').value.trim();
  settings.approval = document.getElementById('s_approval').value.trim();
  settings.phone = document.getElementById('s_phone').value.trim();
  settings.email = document.getElementById('s_email').value.trim();
  settings.principalName = document.getElementById('s_principalName').value.trim();
  settings.principalTitle = document.getElementById('s_principalTitle').value.trim();
  settings.backupEmail = document.getElementById('s_backupEmail').value.trim();

  const fileInput = document.getElementById('s_logo');
  const file = fileInput.files[0];
  const finish = () => {
    applySettingsToHeader();
    saveSettingsLS();
    updateLogoPreview(settings.logoDataUrl);
    showToast('Institution settings saved — this logo will now appear on every certificate', 'success');
  };
  if(file){
    // A new logo was chosen — save it. Otherwise the previously saved logo (settings.logoDataUrl) is kept as-is.
    const reader = new FileReader();
    reader.onload = e => { settings.logoDataUrl = e.target.result; finish(); };
    reader.readAsDataURL(file);
  } else { finish(); }
}

function applySettingsToHeader(){
  document.getElementById('brandCollegeName').textContent = settings.collegeName;
  document.getElementById('brandMark').textContent = brandInitials();
}

/* ======================================================================
   USER MANAGEMENT (Admin only)
   ====================================================================== */
function renderUsersList(){
  const el = document.getElementById('usersList');
  if(!el) return;
  el.innerHTML = users.map(u => `
    <div class="user-row">
      <div><span class="un">${escapeHtml(u.name)}</span> — @${escapeHtml(u.username)}
        <span class="role-badge ${u.role}">${escapeHtml(u.role)}</span></div>
      <div style="display:flex; gap:6px;">
        <button class="btn btn-outline btn-sm" onclick="resetUserPassword('${u.username}')">Reset Password</button>
        ${u.username !== currentUser?.username ? `<button class="btn btn-danger-outline btn-sm" onclick="removeUser('${u.username}')">Remove</button>` : ''}
      </div>
    </div>`).join('');
}
function addUser(){
  if(currentUser.role !== 'admin'){ showToast('Only Admin can add users', 'error'); return; }
  const username = document.getElementById('nu_username').value.trim();
  const name = document.getElementById('nu_name').value.trim();
  const password = document.getElementById('nu_password').value;
  const role = document.getElementById('nu_role').value;
  if(!username || !name || !password){ showToast('Fill in username, name and password', 'error'); return; }
  if(users.find(u => u.username.toLowerCase() === username.toLowerCase())){ showToast('Username already exists', 'error'); return; }
  users.push({ username, name, password, role });
  saveUsers();
  renderUsersList();
  document.getElementById('nu_username').value = '';
  document.getElementById('nu_name').value = '';
  document.getElementById('nu_password').value = '';
  showToast('User added', 'success');
}
function resetUserPassword(username){
  if(currentUser.role !== 'admin') return;
  const np = prompt('Enter new password for ' + username + ':');
  if(!np) return;
  const u = users.find(x => x.username === username);
  if(u){ u.password = np; saveUsers(); showToast('Password updated', 'success'); }
}
function removeUser(username){
  if(currentUser.role !== 'admin') return;
  if(!confirm('Remove user "' + username + '"?')) return;
  users = users.filter(u => u.username !== username);
  saveUsers();
  renderUsersList();
  showToast('User removed', 'success');
}

/* ======================================================================
   BULK IMPORT (CSV) — Admin only (also enforced in UI)
   ====================================================================== */
const CSV_COLUMNS = [
  'SlNo','AdmissionNo','UMISID','RegNo','Name','FatherName','Nationality','Religion',
  'CommunityCaste','Sex','DOB(YYYY-MM-DD)','DateOfAdmission(YYYY-MM-DD)','MediumOfStudy',
  'ClassAtLeaving','PromotionStatus','DateOfLeaving(YYYY-MM-DD)','ReasonForLeaving',
  'DateOfTCApplication(YYYY-MM-DD)','ConductAndCharacter','DateOfIssue(YYYY-MM-DD)',
  'CurrentYear','Branch','AcademicYearFrom','AcademicYearTo','AdmissionYear'
];
const CSV_KEYS = [
  'slNo','admissionNo','umisId','regNo','name','fatherName','nationality','religion',
  'communityCaste','sex','dob','dateOfAdmission','medium','classAtLeaving','promotion',
  'dateOfLeaving','reason','dateOfApplication','conduct','dateOfIssue',
  'currentYear','branch','acadFrom','acadTo','admissionYear'
];

function requireAdmin(actionLabel){
  if(currentUser.role !== 'admin'){ showToast('Only Admin can ' + actionLabel, 'error'); return false; }
  return true;
}

function openImportModal(){
  if(!requireAdmin('bulk import students')) return;
  document.getElementById('importSummary').className = 'import-summary';
  document.getElementById('importSummary').textContent = '';
  document.getElementById('csvFileInput').value = '';
  openModal('importModalOverlay');
}

function csvEscape(val){ const s = String(val ?? ''); if(/[",\n]/.test(s)) return '"' + s.replace(/"/g,'""') + '"'; return s; }

function downloadTemplate(){
  if(!requireAdmin('download the bulk import template')) return;
  const sample = [
    '124','24124','1016332907','24207935','MOHAN T','THANGAPANDI C','INDIAN','HINDU',
    'Refer Community Certificate, Issued by Revenue Authorities','MALE','2007-07-18',
    '2023-07-03','ENGLISH','Diploma in MECHANICAL ENGINEERING - III YEAR - VI SEMESTER',
    'REFER THE MARK SHEET','2026-04-16','COURSE COMPLETED','2026-04-16','GOOD','2026-04-17',
    'III','DIPLOMA IN MECHANICAL ENGINEERING','2023','2026','2023'
  ];
  const csv = CSV_COLUMNS.map(csvEscape).join(',') + '\n' + sample.map(csvEscape).join(',');
  downloadBlob(csv, 'student_bulk_import_template.csv', 'text/csv');
}

function exportCSV(){
  if(!requireAdmin('export student data')) return;
  if(students.length === 0){ showToast('No students to export', 'error'); return; }
  const lines = [CSV_COLUMNS.map(csvEscape).join(',')];
  students.forEach(s => { lines.push(CSV_KEYS.map(k => csvEscape(s[k])).join(',')); });
  downloadBlob(lines.join('\n'), `students_export_${new Date().toISOString().slice(0,10)}.csv`, 'text/csv');
  showToast('CSV exported', 'success');
}

function downloadBlob(content, filename, mime){
  const blob = new Blob([content], { type: mime + ';charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = filename;
  document.body.appendChild(a); a.click(); document.body.removeChild(a);
  URL.revokeObjectURL(url);
}

function handleCSVFile(e){ const file = e.target.files[0]; if(file) parseCSVFile(file); }

function parseCSVFile(file){
  if(currentUser.role !== 'admin'){ showImportSummary('Only Admin can bulk import.', 'err'); return; }
  const reader = new FileReader();
  reader.onload = e => {
    try{
      const rows = parseCSV(e.target.result);
      if(rows.length < 2){ showImportSummary('The file has no data rows.', 'err'); return; }
      let added = 0, skipped = 0;
      for(let i = 1; i < rows.length; i++){
        const row = rows[i];
        if(row.every(c => !c || !c.trim())) continue;
        const nameVal = (row[4] || '').trim();
        const admissionVal = (row[1] || '').trim();
        if(!nameVal || !admissionVal){ skipped++; continue; }
        const student = { id: cryptoId('stu') };
        CSV_KEYS.forEach((key, idx) => { student[key] = (row[idx] || '').trim(); });
        if(!student.slNo) student.slNo = getNextSlNo();
        students.push(student);
        added++;
      }
      saveStudents();
      showImportSummary(`Imported ${added} student${added===1?'':'s'}.` + (skipped ? ` Skipped ${skipped} row${skipped===1?'':'s'} missing Name/Admission No.` : ''), added ? 'ok' : 'err');
      if(added){ renderTable(); renderTCList(); renderBonaList(); showToast(`${added} student${added===1?'':'s'} imported`, 'success'); }
    }catch(err){
      console.error(err);
      showImportSummary('Could not read this file. Make sure it is a valid CSV.', 'err');
    }
  };
  reader.readAsText(file);
}

function showImportSummary(msg, cls){
  const el = document.getElementById('importSummary');
  el.textContent = msg;
  el.className = 'import-summary ' + cls;
}

function parseCSV(text){
  const rows = [];
  let row = [], field = '', inQuotes = false;
  text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
  for(let i = 0; i < text.length; i++){
    const c = text[i];
    if(inQuotes){
      if(c === '"'){ if(text[i+1] === '"'){ field += '"'; i++; } else inQuotes = false; }
      else field += c;
    } else {
      if(c === '"') inQuotes = true;
      else if(c === ','){ row.push(field); field = ''; }
      else if(c === '\n'){ row.push(field); rows.push(row); row = []; field = ''; }
      else field += c;
    }
  }
  if(field.length || row.length){ row.push(field); rows.push(row); }
  return rows.filter(r => r.length > 1 || (r.length === 1 && r[0] !== ''));
}

/* ======================================================================
   REPORTS PAGE
   ====================================================================== */
function setReportRange(range){
  reportRangeFilter = range;
  reportTypeFilter = null;
  document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
  document.querySelector('.filter-chip[data-range="'+range+'"]').classList.add('active');
  renderReports();
}
function setReportTypeFilter(t){
  reportTypeFilter = (reportTypeFilter === t) ? null : t;
  document.querySelectorAll('.filter-chip[data-range="tc"],.filter-chip[data-range="bona"]').forEach(c => c.classList.remove('active'));
  if(reportTypeFilter) document.querySelector('.filter-chip[data-range="'+t+'"]').classList.add('active');
  renderReports();
}

function renderReports(){
  const now = new Date();
  const todayStr = now.toDateString();
  const monthKey = now.getFullYear() + '-' + now.getMonth();
  const yearKey = now.getFullYear();
  const isAdmin = currentUser && currentUser.role === 'admin';

  document.getElementById('rStatToday').textContent = reports.filter(r => new Date(r.timestamp).toDateString() === todayStr).length;
  document.getElementById('rStatMonth').textContent = reports.filter(r => { const d = new Date(r.timestamp); return (d.getFullYear()+'-'+d.getMonth()) === monthKey; }).length;
  document.getElementById('rStatYear').textContent = reports.filter(r => new Date(r.timestamp).getFullYear() === yearKey).length;
  document.getElementById('rStatAll').textContent = reports.length;

  let filtered = reports.slice();
  if(reportRangeFilter === 'daily') filtered = filtered.filter(r => new Date(r.timestamp).toDateString() === todayStr);
  else if(reportRangeFilter === 'monthly') filtered = filtered.filter(r => { const d = new Date(r.timestamp); return (d.getFullYear()+'-'+d.getMonth()) === monthKey; });
  else if(reportRangeFilter === 'yearly') filtered = filtered.filter(r => new Date(r.timestamp).getFullYear() === yearKey);
  if(reportTypeFilter === 'tc') filtered = filtered.filter(r => r.type === 'TC');
  if(reportTypeFilter === 'bona') filtered = filtered.filter(r => r.type === 'BONAFIDE');
  if(!isAdmin) filtered = filtered.filter(r => r.issuedBy === currentUser.username);

  const tbody = document.getElementById('reportsBody');
  const empty = document.getElementById('reportsEmptyState');
  if(filtered.length === 0){ tbody.innerHTML = ''; empty.style.display = 'block'; return; }
  empty.style.display = 'none';
  tbody.innerHTML = filtered.map(r => {
    const d = new Date(r.timestamp);
    return `<tr>
      <td>${d.toLocaleDateString()}</td>
      <td>${d.toLocaleTimeString()}</td>
      <td><span class="type-tag ${r.type}">${r.type === 'TC' ? 'Transfer Cert.' : 'Bonafide'}</span></td>
      <td>${escapeHtml(r.studentName)}</td>
      <td>${escapeHtml(r.admissionNo)}</td>
      <td style="${isAdmin ? '' : 'display:none;'}">${escapeHtml(r.issuedByName || r.issuedBy)}</td>
    </tr>`;
  }).join('');
}

function exportReportsCSV(){
  if(reports.length === 0){ showToast('No report entries to export', 'error'); return; }
  const isAdmin = currentUser.role === 'admin';
  const cols = isAdmin ? ['Date','Time','Type','Student','AdmissionNo','IssuedBy'] : ['Date','Time','Type','Student','AdmissionNo'];
  const lines = [cols.join(',')];
  let rows = reports;
  if(!isAdmin) rows = rows.filter(r => r.issuedBy === currentUser.username);
  rows.forEach(r => {
    const d = new Date(r.timestamp);
    const vals = [d.toLocaleDateString(), d.toLocaleTimeString(), r.type, r.studentName, r.admissionNo];
    if(isAdmin) vals.push(r.issuedByName || r.issuedBy);
    lines.push(vals.map(csvEscape).join(','));
  });
  downloadBlob(lines.join('\n'), `certificate_report_${new Date().toISOString().slice(0,10)}.csv`, 'text/csv');
  showToast('Report exported', 'success');
}

/* ======================================================================
   BACKUP — IndexedDB handle storage + File System Access API + JSZip
   ====================================================================== */
const IDB_NAME = 'cs_backup_db', IDB_STORE = 'handles', IDB_KEY = 'backupDir';
let backupDirHandle = null;

function idbOpen(){
  return new Promise((resolve, reject) => {
    const req = indexedDB.open(IDB_NAME, 1);
    req.onupgradeneeded = () => req.result.createObjectStore(IDB_STORE);
    req.onsuccess = () => resolve(req.result);
    req.onerror = () => reject(req.error);
  });
}
async function idbSet(key, val){
  const db = await idbOpen();
  return new Promise((resolve, reject) => {
    const tx = db.transaction(IDB_STORE, 'readwrite');
    tx.objectStore(IDB_STORE).put(val, key);
    tx.oncomplete = () => resolve(); tx.onerror = () => reject(tx.error);
  });
}
async function idbGet(key){
  const db = await idbOpen();
  return new Promise((resolve, reject) => {
    const tx = db.transaction(IDB_STORE, 'readonly');
    const req = tx.objectStore(IDB_STORE).get(key);
    req.onsuccess = () => resolve(req.result); req.onerror = () => reject(req.error);
  });
}

function fsApiSupported(){ return typeof window.showDirectoryPicker === 'function'; }

async function chooseBackupFolder(){
  if(!fsApiSupported()){
    showToast('Your browser cannot pick a folder — backups will download to your Downloads folder instead', 'error');
    return;
  }
  try{
    const handle = await window.showDirectoryPicker({ id: 'certBackup', mode: 'readwrite' });
    backupDirHandle = handle;
    await idbSet(IDB_KEY, handle);
    refreshBackupFolderStatus();
    showToast('Backup folder selected', 'success');
  }catch(err){
    if(err && err.name !== 'AbortError') console.error(err);
  }
}

async function refreshBackupFolderStatus(){
  const statusEl = document.getElementById('backupFolderStatus');
  const textEl = document.getElementById('backupFolderText');
  if(!fsApiSupported()){
    statusEl.className = 'backup-status warn';
    textEl.textContent = 'Folder auto-write not supported in this browser — use Chrome or Edge on desktop. Backups will download normally.';
    return;
  }
  try{
    const handle = await idbGet(IDB_KEY);
    if(handle){
      backupDirHandle = handle;
      statusEl.className = 'backup-status ok';
      textEl.textContent = `Backup folder set: "${handle.name}". New backups will be saved here.`;
    } else {
      statusEl.className = 'backup-status';
      textEl.textContent = 'No backup folder selected yet.';
    }
  }catch(e){
    statusEl.className = 'backup-status';
    textEl.textContent = 'No backup folder selected yet.';
  }
}

function refreshLastBackupStatus(){
  const last = localStorage.getItem(LS_LASTBACKUP);
  const statusEl = document.getElementById('lastBackupStatus');
  const textEl = document.getElementById('lastBackupText');
  if(last){
    statusEl.className = 'backup-status ok';
    textEl.textContent = 'Last backup: ' + new Date(last).toLocaleString();
  } else {
    statusEl.className = 'backup-status';
    textEl.textContent = 'No backup has been made yet.';
  }
}

function toggleAutoBackup(enabled){
  localStorage.setItem(LS_AUTOBACKUP, enabled ? 'true' : 'false');
  showToast(enabled ? 'Automatic daily backup enabled' : 'Automatic daily backup disabled', 'success');
}

async function buildBackupZip(){
  const zip = new JSZip();
  zip.file('students.json', JSON.stringify(students, null, 2));
  zip.file('reports.json', JSON.stringify(reports, null, 2));
  zip.file('settings.json', JSON.stringify(settings, null, 2));
  zip.file('users.json', JSON.stringify(users, null, 2));
  const csvLines = [CSV_COLUMNS.map(csvEscape).join(',')];
  students.forEach(s => csvLines.push(CSV_KEYS.map(k => csvEscape(s[k])).join(',')));
  zip.file('students.csv', csvLines.join('\n'));
  return zip.generateAsync({ type: 'blob' });
}

function refreshEmailBackupStatus(){
  const statusEl = document.getElementById('emailBackupStatus');
  const textEl = document.getElementById('emailBackupStatusText');
  if(!statusEl) return;
  const configured = !!settings.backupEmail;
  statusEl.className = 'backup-status' + (configured ? ' ok' : ' warn');
  textEl.textContent = configured
    ? `Will open Gmail addressed to ${settings.backupEmail}`
    : 'Not configured yet — fill in Settings → Email Backup Settings.';
}

async function emailBackupNow(){
  if(!settings.backupEmail){
    showToast('Set a Backup Email in Settings first', 'error');
    goPage('settings');
    return;
  }
  showToast('Preparing backup...', '');
  try{
    const blob = await buildBackupZip();
    const stamp = new Date();
    const fname = `backup_${stamp.getFullYear()}-${String(stamp.getMonth()+1).padStart(2,'0')}-${String(stamp.getDate()).padStart(2,'0')}.zip`;

    // Download the zip to the device first
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = fname;
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);

    // Then open Gmail compose, pre-filled, ready for the user to attach the file just downloaded
    const subject = encodeURIComponent(`Certificate System Backup — ${stamp.toLocaleDateString()}`);
    const body = encodeURIComponent(`Backup from ${settings.collegeName || 'Certificate System'}.\n\nA file named "${fname}" was just downloaded to your Downloads folder.\nClick the paperclip (attach) icon below, choose that file, then click Send.`);
    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(settings.backupEmail)}&su=${subject}&body=${body}`;
    window.open(gmailUrl, '_blank');

    localStorage.setItem(LS_LASTBACKUP, new Date().toISOString());
    refreshLastBackupStatus();
    showToast(`Backup downloaded — now attach "${fname}" in the Gmail tab that opened`, 'success');
  }catch(err){
    console.error(err);
    showToast('Email backup failed — please try again', 'error');
  }
}

async function runBackupNow(manual){
  try{
    const blob = await buildBackupZip();
    const stamp = new Date();
    const fname = `backup_${stamp.getFullYear()}-${String(stamp.getMonth()+1).padStart(2,'0')}-${String(stamp.getDate()).padStart(2,'0')}_${String(stamp.getHours()).padStart(2,'0')}${String(stamp.getMinutes()).padStart(2,'0')}.zip`;

    let wroteToFolder = false;
    if(fsApiSupported() && backupDirHandle){
      try{
        let perm = await backupDirHandle.queryPermission({ mode: 'readwrite' });
        if(perm !== 'granted') perm = await backupDirHandle.requestPermission({ mode: 'readwrite' });
        if(perm === 'granted'){
          const fileHandle = await backupDirHandle.getFileHandle(fname, { create: true });
          const writable = await fileHandle.createWritable();
          await writable.write(blob);
          await writable.close();
          wroteToFolder = true;
        }
      }catch(e){ console.error('Folder write failed, falling back to download', e); }
    }
    if(!wroteToFolder){
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = fname;
      document.body.appendChild(a); a.click(); document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }
    localStorage.setItem(LS_LASTBACKUP, new Date().toISOString());
    refreshLastBackupStatus();
    showToast(wroteToFolder ? `Backup saved to "${backupDirHandle.name}"` : 'Backup downloaded (choose a folder to save future backups there automatically)', 'success');
  }catch(err){
    console.error(err);
    showToast('Backup failed — please try again', 'error');
  }
}

function setRestoreStatus(msg, cls){
  const statusEl = document.getElementById('restoreStatus');
  const textEl = document.getElementById('restoreStatusText');
  if(!statusEl) return;
  statusEl.className = 'backup-status' + (cls ? ' ' + cls : '');
  textEl.textContent = msg;
}

async function handleRestoreFile(input){
  const file = input.files && input.files[0];
  if(!file) return;
  if(!confirm('This will REPLACE all students, users, settings and reports currently on this computer with the data from the backup zip. Continue?')){
    input.value = '';
    return;
  }
  try{
    const zip = await JSZip.loadAsync(file);
    let restoredAny = false;

    const readJson = async (name) => {
      const entry = zip.file(name);
      if(!entry) return null;
      const text = await entry.async('string');
      try{ return JSON.parse(text); }catch(e){ return null; }
    };

    const restoredUsers = await readJson('users.json');
    const restoredStudents = await readJson('students.json');
    const restoredSettings = await readJson('settings.json');
    const restoredReports = await readJson('reports.json');

    if(restoredUsers && Array.isArray(restoredUsers) && restoredUsers.length){
      users = restoredUsers;
      saveUsers();
      restoredAny = true;
    }
    if(restoredStudents && Array.isArray(restoredStudents)){
      students = restoredStudents;
      saveStudents();
      restoredAny = true;
    }
    if(restoredSettings && typeof restoredSettings === 'object'){
      settings = Object.assign(settings, restoredSettings);
      saveSettingsLS();
      restoredAny = true;
    }
    if(restoredReports && Array.isArray(restoredReports)){
      reports = restoredReports;
      saveReports();
      restoredAny = true;
    }

    input.value = '';
    if(!restoredAny){
      setRestoreStatus('That zip did not contain any recognizable backup files.', 'warn');
      showToast('Restore failed — invalid backup file', 'error');
      return;
    }
    setRestoreStatus('Backup restored on ' + new Date().toLocaleString() + '. Reloading…', 'ok');
    showToast('Backup restored successfully', 'success');
    setTimeout(() => window.location.reload(), 1200);
  }catch(err){
    console.error(err);
    input.value = '';
    setRestoreStatus('Restore failed — the file may not be a valid backup zip.', 'warn');
    showToast('Restore failed — please check the file', 'error');
  }
}

async function checkAutoBackupOnOpen(){
  const enabled = localStorage.getItem(LS_AUTOBACKUP) === 'true';
  if(!enabled) return;
  const last = localStorage.getItem(LS_LASTBACKUP);
  const lastDay = last ? new Date(last).toDateString() : null;
  if(lastDay === new Date().toDateString()) return; // already backed up today
  try{
    const handle = await idbGet(IDB_KEY);
    if(handle) backupDirHandle = handle;
  }catch(e){}
  // Attempt silent backup; if folder permission needs a user gesture, this will
  // fall back to a downloaded zip instead of failing silently.
  runBackupNow(false);
}
</script>
</body>
</html>
