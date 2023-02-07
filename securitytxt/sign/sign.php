<?php

if (isset($publickeyfile) && !empty($publickeyfile) && file_exists($publickeyfile)) {
    $gpg = new gnupg();
    $gpg->seterrormode(GNUPG_ERROR_WARNING);
    $gpg->setsignmode(GNUPG_SIG_MODE_CLEAR);
    #$privatedata = file_get_contents($privatekeyfile);
    $publicdata = file_get_contents($publickeyfile);
    #$privatekey = $gpg->import($privatedata);
    $publickey = $gpg->import($publicdata);
    #$gpg->addsignkey($privatekey['fingerprint']);
    $gpg->addsignkey($publickey['fingerprint']);
    $signed = $gpg->sign($securitytxt);
    $securitytxt = $signed;
}

?>
