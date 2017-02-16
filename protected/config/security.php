<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// NOTE!!!  You must set the encryption keys ONCE for your application
// Changing the keys with data in the database will render the data USELESS
return array(
                        'cryptAlgorithm'        => 'rijndael-256',
                        'encryptionKey'         => 'Some super secret key used to encrypt our database data.',
                        'hashAlgorithm'         => 'sha1',
                        'validationKey'         => 'Another super secret hashing key',
                );
