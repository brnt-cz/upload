<?php
/**
 * Ochrana adresáře proti přímému procházení
 */
header('HTTP/1.0 403 Forbidden');
exit('Access denied');