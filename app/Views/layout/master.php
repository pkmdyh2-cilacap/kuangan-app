<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Klinik Keuangan' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --bg-dark: #1a1d29;
            --bg-sidebar: #12141d;
            --bg-card: #1e2130;
            --bg-input: #252837;
            --text-primary: #e8e8e8;
            --text-secondary: #8b8d97;
            --accent-blue: #4a6cf7;
            --accent-green: #22c55e;
            --accent-red: #ef4444;
            --accent-yellow: #f59e0b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: 1px solid rgba(255,255,255,0.06);
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--accent-blue);
            margin-bottom: 2px;
        }
        .sidebar-brand small {
            font-size: 12px;
            color: var(--text-secondary);
        }
        .sidebar-menu {
            padding: 16px 12px;
        }
        .sidebar-menu .menu-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            padding: 12px 12px 8px;
            font-weight: 600;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .sidebar-menu a:hover {
            background: rgba(74, 108, 247, 0.1);
            color: var(--text-primary);
        }
        .sidebar-menu a.active {
            background: var(--accent-blue);
            color: #fff;
        }
        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 24px 32px;
            min-height: 100vh;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
        }
        .card-dark {
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 24px;
        }
        .table-dark-custom {
            width: 100%;
            border-collapse: collapse;
        }
        .table-dark-custom th {
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            font-weight: 600;
        }
        .table-dark-custom td {
            padding: 12px 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }
        .table-dark-custom tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }
        .btn-primary-custom {
            background: var(--accent-blue);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s;
        }
        .btn-primary-custom:hover { opacity: 0.85; color: #fff; }
        .btn-sm-custom {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            color: #fff;
        }
        .btn-edit { background: var(--accent-blue); }
        .btn-delete { background: var(--accent-red); }
        .btn-view { background: var(--accent-green); }
        .form-control-dark {
            background: var(--bg-input);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
        }
        .form-control-dark:focus {
            border-color: var(--accent-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.15);
        }
        .form-label-dark {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 6px;
            font-weight: 500;
        }
        .badge-green {
            background: rgba(34, 197, 94, 0.15);
            color: var(--accent-green);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-red {
            background: rgba(239, 68, 68, 0.15);
            color: var(--accent-red);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-blue {
            background: rgba(74, 108, 247, 0.15);
            color: var(--accent-blue);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .metric-card {
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 20px;
        }
        .metric-card .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 12px;
        }
        .metric-card .metric-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .metric-card .metric-label {
            font-size: 13px;
            color: var(--text-secondary);
        }
        .alert-success-custom {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: var(--accent-green);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .alert-danger-custom {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--accent-red);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-secondary);
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <?= $this->include('layout/sidebar') ?>
    <div class="main-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success-custom">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-danger-custom">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
