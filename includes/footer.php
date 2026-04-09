</main>
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3>GVR Web Studio</h3>
                    <p><?php echo __('footer_descripcion'); ?></p>
                    <div class="social-links">
                        <a href="https://facebook.com/GVRWebStudio" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://instagram.com/gvr_webstudio" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/gvr_webstudio" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h4><?php echo __('footer_enlaces'); ?></h4>
                    <ul>
                        <li><a href="<?php echo $ruta_raiz; ?>index.php"><?php echo __('nav_inicio'); ?></a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/servicios.php"><?php echo __('nav_servicios'); ?></a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/portfolio.php"><?php echo __('nav_portfolio'); ?></a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/blog.php"><?php echo __('nav_blog'); ?></a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/contacto.php"><?php echo __('nav_contacto'); ?></a></li>
                        <li><a href="<?php echo $ruta_raiz; ?>pages/sobre-nosotros.php"><?php echo __('nav_sobre_nosotros'); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h4><?php echo __('footer_contacto'); ?></h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> <a href="tel:693376377">693 37 63 77</a></li>
                        <li><i class="fas fa-phone"></i> <a href="tel:644848658">644 84 86 58</a></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:gvrwebstudio@gmail.com">gvrwebstudio@gmail.com</a></li>
                        <li><i class="fas fa-clock"></i> <?php echo __('contacto_horario_texto'); ?></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 GVR Web Studio. <?php echo __('footer_derechos'); ?></p>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo $ruta_raiz; ?>assets/js/main.js"></script>
</body>
</html>