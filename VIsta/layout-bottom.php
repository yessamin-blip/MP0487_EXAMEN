<?php include __DIR__ . '/cookies-banner.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/cookies.js"></script>
<?php if (isset($page_js)): ?>
  <script src="<?= htmlspecialchars($page_js) ?>"></script>
<?php endif; ?>
</body>
</html>