<?php

namespace Modules\Actors\SEO;

enum SeoSitePages: string
{
    case HOME           = 'home';
    case MATRIX_HOME    = 'matrix';
    case NATAL_HOME     = 'natal';
    case CELEBRITIES    = 'celebrities';
    case GLOSSARY       = 'glossary';
    case LOGIN          = 'login';
    case REGISTER       = 'register';
    case FEED           = 'feed';
}
