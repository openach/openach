<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class CPgsqlTestSchema extends CPgsqlSchema
{
        public function checkIntegrity($check=true,$schema='')
        {
                $db = $this->getDbConnection();
                if ($check) {
                    $db->createCommand("SET CONSTRAINTS ALL DEFERRED")->execute();
                } else {
                    $db->createCommand("SET CONSTRAINTS ALL IMMEDIATE")->execute();
                }
        }
}
