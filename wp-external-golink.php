<?php

function wp_seo_exterlnal_golink_html( ) {
    $external = str_replace('target=', '', $_SERVER['QUERY_STRING']);
    $links = wp_parse_url( esc_url_raw( $external ) );
    $link = $links['scheme'].'://'.$links['host'];
    if( strpos($external, "&") ) { 
        $external = substr_replace($external, "?", strpos($external, "&"), 1); 
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name='robots' content='noindex, nofollow' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title><?php bloginfo( 'name' ); ?> - 安全中心提示</title>
    <style>
        body,
        h1,
        p {
            margin: 0;
            padding: 0;
        }
        a {
            text-decoration: none;
        }
        button {
            padding: 0;
            font-family: inherit;
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
        }
        html {
            width: 100%;
            height: 100%;
            background-color: #eff2f5;
        }
        body {
            padding-top: 100px;
            color: #222;
            font-size: 13px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.5;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        @media (max-width: 620px) {
            body {
                font-size: 15px;
            }
        }
        .button {
            display: inline-block;
            padding: 10px 16px;
            color: #fff;
            font-size: 14px;
            line-height: 1;
            background-color: #0077d9;
            border-radius: 3px;
        }
        .gray {
            background-color: #868686!important;
        }
        @media (max-width: 620px) {
            .button {
                font-size: 16px;
            }
        }
        .button:hover {
            background-color: #0070cd;
        }
        .button:active {
            background-color: #0077d9;
        }
        .link-button {
            color: #105cb6;
            font-size: 13px;
        }
        @media (max-width: 620px) {
            .link-button {
                font-size: 15px;
            }
        }
        .logo,
        .wrapper {
            margin: auto;
            padding-left: 30px;
            padding-right: 30px;
            max-width: 540px;
        }
        .wrapper {
            padding-top: 25px;
            padding-bottom: 25px;
            background-color: #f7f7f7;
            border: 1px solid #babbbc;
            border-radius: 5px;
        }
        @media (max-width: 620px) {
            .logo,
            .wrapper {
                margin: 0 10px;
            }
        }
        h1 {
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
        }
		h1.title {
			margin-left: -25px;
		}
        @media (max-width: 620px) {
            h1 {
                font-size: 18px;
            }
        }
        .warning {
            color: #c33;
        }
        .link {
            margin-top: 12px;
            word-wrap: normal;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .link.is-expanded {
            word-wrap: break-word;
            white-space: normal;
        }
        .actions {
            margin-top: 15px;
            padding-top: 30px;
            text-align: right;
            border-top: 1px solid #d8d8d8;
        }
        .actions .link-button + .link-button {
            margin-left: 30px;
        }
        .tip {
            position: relative;
            display: none;
            margin-top: 30px;
            padding-top: 18px;
            color: #999;
            text-align: left;
            background: #f7f7f7;
            border-top: 1px solid #d8d8d8;
            opacity: 0;
            transition: opacity .2s ease-out;
        }
        .tip.is-visible {
            opacity: 1;
        }
        .tip:after, .tip:before {
            position: absolute;
            bottom: 100%;
            right: 5em;
            content: " ";
            height: 0;
            width: 0;
            border: solid transparent;
            pointer-events: none;
        }
        .tip:after {
            margin-right: -6px;
            border-color: rgba(247, 247, 247, 0);
            border-bottom-color: #f7f7f7;
            border-width: 6px;
        }
        .tip:before {
            margin-right: -7px;
            border-color: rgba(216, 216, 216, 0);
            border-bottom-color: #d2d2d2;
            border-width: 7px;
        }
        #footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 20px;
            color: #50575e;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="logo">
    <h1 class="title">安全中心提示</h1>
</div>
<div class="wrapper">
	<div class="content">
		<h1>即将离开 <?php bloginfo( 'name' ); ?> 提醒</h1>
		<p class="info">您即将离开 <?php bloginfo( 'name' ); ?>，请注意您的帐号和财产安全。</p>
		<p class="link"><?php echo esc_url( $link ); ?></p>
	</div>
	<div class="actions">
		<a class="button" href="<?php echo esc_url( $external ); ?>">继续访问</a>
		<a class="button gray" href="<?php bloginfo( 'url' ); ?>">返回首页</a>
	</div>
</div>
<div id="footer">
	WordPress External Link Plugin By <a href="https://www.imahui.com" target="_blank">iMahui</a>
</div>
</body>
</html>
<?php }