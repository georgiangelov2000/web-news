</main>
<footer>
    <div class="amazon-footer-bar mt-5 py-2">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <i class="bi bi-box-seam fs-4 text-warning me-2"></i>
                <span class="fw-bold">&copy; <?= date('Y') ?> My App</span>
                <span class="ms-3 small">Inspired by Amazon design</span>
            </div>
            <div class="footer-links d-flex flex-wrap gap-3">
                <a href="/about" class="text-decoration-none text-secondary">About</a>
                <a href="/contact" class="text-decoration-none text-secondary">Contact</a>
                <a href="/privacy" class="text-decoration-none text-secondary">Privacy Policy</a>
                <a href="/terms" class="text-decoration-none text-secondary">Terms of Service</a>
                <a href="/pricing" class="text-decoration-none text-secondary">Pricing</a>
                <a href="/faq" class="text-decoration-none text-secondary">FAQ</a>
                <a href="/register" class="text-decoration-none text-secondary">Register</a>
                <a href="/login" class="text-decoration-none text-secondary">Login</a>
            </div>
        </div>
        <div class="container text-center small mt-2 text-muted">
            Made by <a href="https://github.com/georgiangelov2000" class="text-secondary"
                target="_blank">georgiangelov2000</a>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS bundle from CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
<script src="/assets/app.js"></script>

<!-- Example: Show success notification from PHP session -->
<?php if (!empty($_SESSION['toastr_success'])): ?>
    <script>
        toastr.success("<?= addslashes($_SESSION['toastr_success']) ?>");
    </script>
    <?php unset($_SESSION['toastr_success']); endif; ?>

<!-- Example: Show error notification from PHP session -->
<?php if (!empty($_SESSION['toastr_error'])): ?>
    <script>
        toastr.error("<?= addslashes($_SESSION['toastr_error']) ?>");
    </script>
    <?php unset($_SESSION['toastr_error']); endif; ?>

</body>

</html>