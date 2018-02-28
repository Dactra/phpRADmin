<?php
# PHPki CONFIGURATION FILE
# Automatically generated by PHPki.  Edit at your own peril.
#
$config['organization'] = 'phpRADmin';
$config['unit']         = 'Networking and Security';
$config['contact']      = 'phpradmin-devel@lists.sourceforge.net';
$config['locality']     = 'Madrid';
$config['province']     = 'Madrid';
$config['country']      = 'ES';
$config['common_name']  = 'phpRADmin Certificate Authority';

# Store Directory
$config['store_dir'] = '/usr/local/phpradmin/conf/phpki-store';

# Location HTTP Password File
$config['passwd_file'] = '/var/www/phpkipasswd';

# Password for CA root certificate.
$config['ca_pwd'] = 'passwordpra';

# Number of years the root certificate is good.
$config['expiry'] = '10';

# CA certificate key size
$config['keysize'] = '1024';

# This is superimposed over the PHPki logo on each page.
$config['header_title'] = 'Certificate Authority';

# String to prefix cer and crl uploads
$config['ca_prefix'] = '';

# Location of your OpenSSL binary.
$config['openssl_bin'] = '/usr/bin/openssl';

# Base URL
$config['base_url']  = 'http://servidor/phpradmin/include/phpki/';

# Who users should contact if they have technical difficulty with
# your certificate authority site.
$config['getting_help'] = '<b>Contact:</b><br>
First-Name Last-Name<br>
Company/Organization Name<br>
Address Line #1<br>
Address Line #2<br>
City, State, ZipCode<br>
<br>
Phone: (000) 000-0000<br>
E-mail: <a href=mailto:someone@somewhere.com>someone@somewhere.com</a>&nbsp;&nbsp;&nbsp;<i><b>E-mail is preferred.</b></i><br>';

#
# You shouldn't change anything below this line.  If you do, don't
# ask for help!
#
$config['home_dir']      = $config['store_dir'];
$config['ca_dir']        = $config['home_dir'] . '/CA';
$config['private_dir']   = $config['ca_dir']   . '/private';
$config['new_certs_dir'] = $config['ca_dir']   . '/newcerts';
$config['cert_dir']      = $config['ca_dir']   . '/certs';
$config['req_dir']       = $config['ca_dir']   . '/requests';
$config['crl_dir']       = $config['ca_dir']   . '/crl';
$config['pfx_dir']       = $config['ca_dir']   . '/pfx';
$config['index']         = $config['ca_dir']   . '/index.txt';
$config['serial']        = $config['ca_dir']   . '/serial';
$config['random']        = $config['home_dir'] . '/.rnd';
$config['cacert_pem']    = $config['cert_dir'] . '/cacert.pem';
$config['cacrl_pem']     = $config['crl_dir'] . '/cacrl.pem';
$config['cacrl_der']     = $config['crl_dir'] . '/cacrl.crl';
$config['cakey']         = $config['private_dir'] . '/cakey.pem';

# Default OpenSSL Config File.
$config['openssl_cnf']   = $config['home_dir'] . '/config/openssl.cnf';

define('OPENSSL',$config[openssl_bin].' ');
define('X509', OPENSSL . ' x509 ');
define('PKCS12', "RANDFILE='$config[random]' " . OPENSSL . ' pkcs12 ');
define('CA', OPENSSL . ' ca ');
define('REQ', OPENSSL . ' req ');
define('CRL', OPENSSL . ' crl ');

?>