<?php
$pageTitle = 'Unauthorized Access';
include __DIR__ . '/layouts/header.php';
?>

<style>
.unauthorized-wrapper {
    max-width: 520px;
    margin: 90px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(33,52,96,0.13), 0 1.5px 6px rgba(33,52,96,0.09);
    padding: 48px 36px 40px 36px;
    text-align: center;
}

.unauthorized-wrapper .icon-circle {
    background: linear-gradient(135deg, #ffd814 60%, #ffecb3 100%);
    color: #876800;
    border-radius: 50%;
    width: 82px;
    height: 82px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 22px auto;
    font-size: 2.8rem;
    box-shadow: 0 2px 10px rgba(255,216,20,0.13);
}

.unauthorized-wrapper h1 {
    font-size: 2.1rem;
    font-weight: 700;
    color: #213460;
    margin-bottom: 1.1rem;
}

.unauthorized-wrapper p {
    color: #556080;
    font-size: 1.12rem;
    margin-bottom: 1.7rem;
}

.unauthorized-wrapper .btn-primary {
    background: linear-gradient(90deg, #ffd814 60%, #ffecb3 100%);
    border: none;
    border-radius: 50px;
    color: #876800;
    font-weight: 600;
    padding: 10px 32px;
    font-size: 1.08rem;
    transition: background 0.2s;
    margin-bottom: 10px;
}

.unauthorized-wrapper .btn-primary:hover {
    background: #ffe484;
    color: #213460;
}

.unauthorized-wrapper .btn-secondary {
    border-radius: 50px;
    padding: 10px 28px;
    border: 1.5px solid #dcdcdc;
    background: #f8fafb;
    color: #213460;
    font-weight: 500;
    font-size: 1.08rem;
    transition: all 0.2s ease-in-out;
    margin-left: 12px;
}

.unauthorized-wrapper .btn-secondary:hover {
    background: #f0f0f0;
    color: #b38d00;
}
</style>

<div class="unauthorized-wrapper">
    <div class="icon-circle">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <h1>Unauthorized Access</h1>
    <p>
        Sorry, you do not have permission to view this page.<br>
        Please log in with an authorized account or return to the homepage.
    </p>
    <div>
        <a href="/login" class="btn btn-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        <a href="/" class="btn btn-secondary"><i class="bi bi-house-door me-1"></i> Home</a>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>