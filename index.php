<?php
include_once __DIR__ . '/includes/common.php';

$path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

$api = new WebsiteApiModule();
$faqs = $api->fetch_data('get-faqs');
$pricing = $api->fetch_data('get-pricing');
$homePage = $api->fetch_data('get-homepage');
$resources = $api->fetch_data('get-resources');
$checkout = $api->fetch_data('checkout', 'app');
$analyticsScript = $_ENV['JS_ANALYTICS_SCRIPT'];

if (isset($homePage['enable_splash_page']) && $homePage['enable_splash_page'] == 1) {
    $path = '';
}

if (preg_match("#^resource/(.+)#", $path, $matches)) {

    $resourceSlug = $matches[1];
    $resource = $api->fetch_data('get-resource/' . $resourceSlug);

    // Check if the post exists
    if ($resource) {
        $params = [
            'page_title' => $resource['data']['title'],
            'resource' => $resource['data'],
            'analytics_script' => $analyticsScript
        ];
        $template = 'templates/resource-single.latte';
    } else {
        // Post not found, render a 404 page
        header("HTTP/1.0 404 Not Found");
        $params = ['page_title' => '404', 'analytics_script' => $analyticsScript];
        $template = 'templates/404.latte';
    }
} else {
    switch ($path) {
        case '':
        case 'home':
            $params = ['page_title' => 'Marketing', 'analytics_script' => $analyticsScript, 'enable_splash' => $homePage['enable_splash_page']];
            // or $params = new TemplateParameters(/* ... */);
            $template = 'templates/index.latte';
            break;
        case 'pricing':
            $params = ['page_title' => 'Pricing', 'faqs' => $faqs, 'pricing' => $pricing, 'analytics_script' => $analyticsScript];
            $template = 'templates/pricing.latte';
            break;
        case 'about':
            $params = ['page_title' => 'About', 'analytics_script' => $analyticsScript];
            $template = 'templates/about.latte';
            break;
        case 'post-an-award':
            $params = ['page_title' => 'Post an Award', 'analytics_script' => $analyticsScript];
            $template = 'templates/post-an-award.latte';
            break;
        case 'contact-us':
            $params = ['page_title' => 'Contact Us', 'analytics_script' => $analyticsScript];
            $template = 'templates/contact-us.latte';
            break;
        case 'privacy-policy':
            $params = ['page_title' => 'Privacy Policy', 'analytics_script' => $analyticsScript];
            $template = 'templates/privacy-policy.latte';
            break;
        case 'terms-of-service':
            $params = ['page_title' => 'Terms of Service', 'analytics_script' => $analyticsScript];
            $template = 'templates/terms-of-service.latte';
            break;
        case 'confirmation':
            $params = ['page_title' => 'Confirmation', 'analytics_script' => $analyticsScript];
            $template = 'templates/confirmation.latte';
            break;
        case 'checkout':
            $params = ['page_title' => 'checkout', 'checkout' => $checkout, 'analytics_script' => $analyticsScript];
            $template = 'templates/checkout.latte';
            break;
        case 'checkout-confirmation':
            $params = ['page_title' => 'Confirmation', 'analytics_script' => $analyticsScript];
            $template = 'templates/checkout-confirmation.latte';
            break;
        case 'resources':
            $params = ['page_title' => 'Resources', 'resources' => $resources, 'analytics_script' => $analyticsScript];
            $template = 'templates/resources.latte';
            break;
        case '500':
            $params = ['page_title' => '500', 'analytics_script' => $analyticsScript];
            $template = 'templates/500.latte';
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            $params = ['page_title' => '404'];
            $template = 'templates/404.latte';
            break;
    }
}
// render to output
$latte->render($template, $params);
