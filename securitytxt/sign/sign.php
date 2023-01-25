<?php

if (isset($publickeyfile) && !empty($publickeyfile) && file_exists($publickeyfile)) {
    $gpg = new gnupg();
    $gpg->seterrormode(GNUPG_ERROR_WARNING);
    $gpg->setsignmode(GNUPG_SIG_MODE_CLEAR);
    $publicdata = file_get_contents($publickeyfile);
    $publickey = $gpg->import($publicdata);
    $gpg->addsignkey($publickey['fingerprint']);
    $signed = $gpg->sign($securitytxt);
    $securitytxt = $signed;
}

?>
