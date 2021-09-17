<?php

if($authPageName == "page" and $authPage == NULL) {
    return header('Location:errors/auth');
}

if($authPageName == "content" and $authCont == NULL) {
    return header('Location:errors/auth');
}

if($authPageName == "setting" and $authSetting == NULL) {
    return header('Location:errors/auth');
}