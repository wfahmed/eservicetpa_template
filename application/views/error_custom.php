<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .error-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .error-container h1 {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .error-container p {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 20px;
        }
        .error-container a {
            color: #007bff;
            text-decoration: none;
        }
        .error-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1>Error</h1>
    <p><?= $message; ?></p>
    <a href="<?= base_url($return); ?>">عودة </a>
</div>

</body>
</html>
