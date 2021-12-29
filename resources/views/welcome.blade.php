<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--

Page    : index / MobApp
Version : 1.0
Author  : Colorlib
URI     : https://colorlib.com

 -->

<head>
    <title>{{env('APP_NAME')}}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{env('APP_NAME')}} - A chat app that appends a smiley face for each message .">
    <meta name="keywords" content="HTML5, bootstrap, mobile, app, landing, ios, android, responsive">

    <!-- Font -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/landing/css/bootstrap.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="/landing/css/themify-icons.css">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="/landing/css/owl.carousel.min.css">
    <!-- Main css -->
    <link href="/landing/css/style.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="/landing/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/landing/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/landing/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/landing/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/landing/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/landing/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/landing/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/landing/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/landing/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/landing/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/landing/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/landing/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/landing/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/landing/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/landing/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MYF36LSC32"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-MYF36LSC32');
    </script>
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="30">

<!-- Nav Menu -->

<div class="nav-menu fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <a class="navbar-brand" href="/"><img src="/landing/images/logo.png" class="img-fluid" alt="logo"
                                                          style="max-height: 30px"> {{env('APP_NAME')}}</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
                            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link active" href="#home">Home<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                            <li class="nav-item"><a class="nav-link" href="#subscribe">Subscribe</a></li>
                            <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{config('social.github_backend')}}"
                                   target="_blank">Backend on GitHub</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{config('social.github_app')}}"
                                   target="_blank">App on GitHub</a>
                            </li>

                            @if(env('APP_STORE_LINK'))
                                <li class="nav-item"><a href="#download"
                                                        class="btn btn-outline-light my-3 my-sm-0 ml-lg-3">Download</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>


<header class="bg-gradient" id="home">
    <div class="container mt-5">
        <h1>{{env('APP_NAME')}} - An open-source chat app that doesn't save messages</h1>
        <p class="tagline">This is a regular chat, but it's open-source and it doesn't save any messages. Your chat
            history is active as long as you are in a conversation.</p>
    </div>
    <div class="img-holder mt-3"><img src="/landing/images/iphonex.png" alt="phone" class="img-fluid"></div>
</header>

<div class="section light-bg" id="features">
    <div class="container">

        <div class="section-title">
            <small>HIGHLIGHTS</small>
            <h3>Features you love</h3>
        </div>


        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-face-smile gradient-fill ti-3x mr-3"></span>
                            <div class="media-body">
                                <h4 class="card-title">Open-source</h4>
                                <p class="card-text">
                                    It's like any other chat but it's open-source and you can see what's happening
                                    behind the scene.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-close gradient-fill ti-3x mr-3"></span>
                            <div class="media-body">
                                <h4 class="card-title">No history</h4>
                                <p class="card-text">
                                    History is active as long as you have conversation opened. Once you close the
                                    conversation messages disappear.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-save gradient-fill ti-3x mr-3"></span>
                            <div class="media-body">
                                <h4 class="card-title">No storing</h4>
                                <p class="card-text">We literally don't save messages to the database. <a
                                        href="{{config('social.github_backend')}}" target="_blank">See for your self</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- // end .section -->


<div class="section" id="subscribe">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <h2>Sign up for a waiting list</h2>
                <p class="mb-4">Don't miss our launch day, get notified :D</p>
                <!-- Begin Mailchimp Signup Form -->
                <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7_dtp.css" rel="stylesheet" type="text/css">
                <style type="text/css">
                    #mc_embed_signup {
                        background: #fff;
                        clear: left;
                        font: 14px Helvetica, Arial, sans-serif;
                    }

                    /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
                       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                </style>
                <div id="mc_embed_signup">
                    <form
                        action="https://gmail.us20.list-manage.com/subscribe/post?u=183425b6d381296d3469a1588&amp;id=780b0c11d4"
                        method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                        target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">
                            <h2>Subscribe</h2>
                            <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
                            <div class="mc-field-group">
                                <label for="mce-EMAIL">Email Address <span class="asterisk">*</span>
                                </label>
                                <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                            </div>
                            <div class="mc-field-group">
                                <label for="mce-FNAME">First Name <span class="asterisk">*</span>
                                </label>
                                <input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
                            </div>
                            <div class="mc-field-group" style="display:none">
                                <label for="mce-group[8039]">PhantomChat </label>
                                <select name="group[8039]" class="REQ_CSS" id="mce-group[8039]">
                                    <option value=""></option>
                                    <option value="2" selected>PhantomChat</option>

                                </select>
                            </div>
                            <div id="mce-responses" class="clear foot">
                                <div class="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                                                                                      name="b_183425b6d381296d3469a1588_780b0c11d4"
                                                                                                      tabindex="-1"
                                                                                                      value=""></div>
                            <div class="optionalParent">
                                <div class="clear foot">
                                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"
                                           class="button">
                                    <p class="brandingLogo"><a href="http://eepurl.com/hQvkdf"
                                                               title="Mailchimp - email marketing made easy and fun"><img
                                                src="https://eep.io/mc-cdn-images/template_images/branding_logo_text_dark_dtp.svg"></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <script type='text/javascript'
                        src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
                <script type='text/javascript'>(function ($) {
                        window.fnames = new Array();
                        window.ftypes = new Array();
                        fnames[0] = 'EMAIL';
                        ftypes[0] = 'email';
                        fnames[1] = 'FNAME';
                        ftypes[1] = 'text';
                    }(jQuery));
                    var $mcj = jQuery.noConflict(true);</script>
                <!--End mc_embed_signup-->

            </div>
        </div>
        <div class="perspective-phone">
            <img src="/landing/images/perspective.png" alt="perspective phone" class="img-fluid">
        </div>
    </div>

</div>

<!-- // end .section -->

<?php /*
<div class="section light-bg">
    <div class="container">
        <div class="section-title">
            <small>FEATURES</small>
            <h3>Do more with our app</h3>
        </div>

        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#communication">Communication</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#schedule">Scheduling</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#messages">Messages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#livechat">Live Chat</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="communication">
                <div class="d-flex flex-column flex-lg-row">
                    <img src="/landing/images/graphic.png" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    <div>

                        <h2>Communicate with ease</h2>
                        <p class="lead">Uniquely underwhelm premium outsourcing with proactive leadership skills. </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. Ut placerat dui eu nulla
                            congue tincidunt ac a nibh. Mauris accumsan pulvinar lorem placerat volutpat. Praesent quis facilisis elit. Sed condimentum neque quis ex porttitor,
                        </p>
                        <p> malesuada faucibus augue aliquet. Sed elit est, eleifend sed dapibus a, semper a eros. Vestibulum blandit vulputate pharetra. Phasellus lobortis leo a nisl euismod, eu faucibus justo sollicitudin. Mauris consectetur, tortor
                            sed tempor malesuada, sem nunc porta augue, in dictum arcu tortor id turpis. Proin aliquet vulputate aliquam.
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="schedule">
                <div class="d-flex flex-column flex-lg-row">
                    <div>
                        <h2>Scheduling when you want</h2>
                        <p class="lead">Uniquely underwhelm premium outsourcing with proactive leadership skills. </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. Ut placerat dui eu nulla
                            congue tincidunt ac a nibh. Mauris accumsan pulvinar lorem placerat volutpat. Praesent quis facilisis elit. Sed condimentum neque quis ex porttitor,
                        </p>
                        <p> malesuada faucibus augue aliquet. Sed elit est, eleifend sed dapibus a, semper a eros. Vestibulum blandit vulputate pharetra. Phasellus lobortis leo a nisl euismod, eu faucibus justo sollicitudin. Mauris consectetur, tortor
                            sed tempor malesuada, sem nunc porta augue, in dictum arcu tortor id turpis. Proin aliquet vulputate aliquam.
                        </p>
                    </div>
                    <img src="/landing/images/graphic.png" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                </div>
            </div>
            <div class="tab-pane fade" id="messages">
                <div class="d-flex flex-column flex-lg-row">
                    <img src="/landing/images/graphic.png" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    <div>
                        <h2>Realtime Messaging service</h2>
                        <p class="lead">Uniquely underwhelm premium outsourcing with proactive leadership skills. </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. Ut placerat dui eu nulla
                            congue tincidunt ac a nibh. Mauris accumsan pulvinar lorem placerat volutpat. Praesent quis facilisis elit. Sed condimentum neque quis ex porttitor,
                        </p>
                        <p> malesuada faucibus augue aliquet. Sed elit est, eleifend sed dapibus a, semper a eros. Vestibulum blandit vulputate pharetra. Phasellus lobortis leo a nisl euismod, eu faucibus justo sollicitudin. Mauris consectetur, tortor
                            sed tempor malesuada, sem nunc porta augue, in dictum arcu tortor id turpis. Proin aliquet vulputate aliquam.
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="livechat">
                <div class="d-flex flex-column flex-lg-row">
                    <div>
                        <h2>Live chat when you needed</h2>
                        <p class="lead">Uniquely underwhelm premium outsourcing with proactive leadership skills. </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. Ut placerat dui eu nulla
                            congue tincidunt ac a nibh. Mauris accumsan pulvinar lorem placerat volutpat. Praesent quis facilisis elit. Sed condimentum neque quis ex porttitor,
                        </p>
                        <p> malesuada faucibus augue aliquet. Sed elit est, eleifend sed dapibus a, semper a eros. Vestibulum blandit vulputate pharetra. Phasellus lobortis leo a nisl euismod, eu faucibus justo sollicitudin. Mauris consectetur, tortor
                            sed tempor malesuada, sem nunc porta augue, in dictum arcu tortor id turpis. Proin aliquet vulputate aliquam.
                        </p>
                    </div>
                    <img src="/landing/images/graphic.png" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                </div>
            </div>
        </div>


    </div>
</div>
 */ ?>
<!-- // end .section -->

<?php /*
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="/landing/images/dualphone.png" alt="dual phone" class="img-fluid">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div>
                    <div class="box-icon"><span class="ti-rocket gradient-fill ti-3x"></span></div>
                    <h2>Launch your App</h2>
                    <p class="mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Obcaecati vel exercitationem eveniet vero maxime ratione </p>
                    <a href="#" class="btn btn-primary">Read more</a></div>
            </div>
        </div>

    </div>

</div>
 */?>
<!-- // end .section -->

<?php /*
<div class="section light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
                <ul class="list-unstyled ui-steps">
                    <li class="media">
                        <div class="circle-icon mr-4">1</div>
                        <div class="media-body">
                            <h5>Create an Account</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium obcaecati vel exercitationem </p>
                        </div>
                    </li>
                    <li class="media my-4">
                        <div class="circle-icon mr-4">2</div>
                        <div class="media-body">
                            <h5>Share with friends</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium obcaecati vel exercitationem eveniet</p>
                        </div>
                    </li>
                    <li class="media">
                        <div class="circle-icon mr-4">3</div>
                        <div class="media-body">
                            <h5>Enjoy your life</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium obcaecati vel exercitationem </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <img src="/landing/images/iphonex.png" alt="iphone" class="img-fluid">
            </div>

        </div>

    </div>

</div>
 */?>
<!-- // end .section -->


<?php /*
<div class="section">
    <div class="container">
        <div class="section-title">
            <small>TESTIMONIALS</small>
            <h3>What our Customers Says</h3>
        </div>

        <div class="testimonials owl-carousel">
            <div class="testimonials-single">
                <img src="/landing/images/client.png" alt="client" class="client-img">
                <blockquote class="blockquote">Uniquely streamline highly efficient scenarios and 24/7 initiatives. Conveniently embrace multifunctional ideas through proactive customer service. Distinctively conceptualize 2.0 intellectual capital via user-centric partnerships.</blockquote>
                <h5 class="mt-4 mb-2">Crystal Gordon</h5>
                <p class="text-primary">United States</p>
            </div>
            <div class="testimonials-single">
                <img src="/landing/images/client.png" alt="client" class="client-img">
                <blockquote class="blockquote">Uniquely streamline highly efficient scenarios and 24/7 initiatives. Conveniently embrace multifunctional ideas through proactive customer service. Distinctively conceptualize 2.0 intellectual capital via user-centric partnerships.</blockquote>
                <h5 class="mt-4 mb-2">Crystal Gordon</h5>
                <p class="text-primary">United States</p>
            </div>
            <div class="testimonials-single">
                <img src="/landing/images/client.png" alt="client" class="client-img">
                <blockquote class="blockquote">Uniquely streamline highly efficient scenarios and 24/7 initiatives. Conveniently embrace multifunctional ideas through proactive customer service. Distinctively conceptualize 2.0 intellectual capital via user-centric partnerships.</blockquote>
                <h5 class="mt-4 mb-2">Crystal Gordon</h5>
                <p class="text-primary">United States</p>
            </div>
        </div>

    </div>

</div>
 */?>
<!-- // end .section -->


<div class="section light-bg" id="gallery">
    <div class="container">
        <div class="section-title">
            <small>GALLERY</small>
            <h3>App Screenshots</h3>
        </div>

        <div class="img-gallery owl-carousel owl-theme">
            <img src="/landing/images/screen1.png" alt="image">
            <img src="/landing/images/screen2.png" alt="image">
        </div>

    </div>

</div>
<!-- // end .section -->

<?php /*
<div class="section pt-0">
    <div class="container">
        <div class="section-title">
            <small>FAQ</small>
            <h3>Frequently Asked Questions</h3>
        </div>

        <div class="row pt-4">
            <div class="col-md-6">
                <h4 class="mb-3">Can I try before I buy?</h4>
                <p class="light-font mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. </p>
                <h4 class="mb-3">What payment methods do you accept?</h4>
                <p class="light-font mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. </p>

            </div>
            <div class="col-md-6">
                <h4 class="mb-3">Can I change my plan later?</h4>
                <p class="light-font mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. </p>
                <h4 class="mb-3">Do you have a contract?</h4>
                <p class="light-font mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum, urna eu pellentesque pretium, nisi nisi fermentum enim, et sagittis dolor nulla vel sapien. Vestibulum sit amet mattis ante. </p>

            </div>
        </div>
    </div>

</div>
 */?>
<!-- // end .section -->

@if(env('APP_STORE_LINK'))
    <div class="section bg-gradient" id="download">
        <div class="container">
            <div class="call-to-action">
                <h2>Download Anywhere</h2>
                <?php /*
            <p class="tagline">Available for all major mobile and desktop platforms. Rapidiously visualize optimal ROI rather than enterprise-wide methods of empowerment. </p>
            */?>
                <div class="my-4">

                    <a href="{{env('APP_STORE_LINK')}}" target="_blank" class="btn btn-light"><img
                            src="/landing/images/appleicon.png" alt="icon"> App Store</a>
                    <?php /*
                <a href="#" class="btn btn-light"><img src="/landing/images/playicon.png" alt="icon"> Google play</a>
                */ ?>
                </div>
            </div>
        </div>
    </div>
    <!-- // end .section -->
@endif

<div class="light-bg py-5" id="contact">
    <div class="container">
        <div class="row">
            <?php /*
            <div class="col-lg-6 text-center text-lg-left">

                <p class="mb-2"> <span class="ti-location-pin mr-2"></span> 1485 Pacific St, Brooklyn, NY 11216 USA</p>
                <div class=" d-block d-sm-inline-block">
                    <p class="mb-2">
                        <span class="ti-email mr-2"></span>
                        <a class="mr-4" href="mailto:{{config('mail.from.address')}}" target="_blank">

                        </a>
                    </p>
                </div>

            </div>
          */ ?>
            <div class="col-lg-6">
                <div class="social-icons">
                    <a href="{{config('social.twitter')}}" target="_blank">
                        <span class="ti-twitter-alt"></span>
                    </a>
                    <?php /*
                    <a href="#"><span class="ti-facebook"></span></a>
                    <a href="#"><span class="ti-instagram"></span></a>
                    */ ?>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- // end .section -->
<footer class="my-5 text-center">
    <!-- Copyright removal is not prohibited! -->
    <p class="mb-2"><small>COPYRIGHT © <?= date('Y') ?>. ALL RIGHTS RESERVED. MOBAPP TEMPLATE BY <a
                href="https://colorlib.com">COLORLIB</a></small></p>
    <?php /*
    <small>
        <a href="#" class="m-2">PRESS</a>
        <a href="#" class="m-2">TERMS</a>
        <a href="#" class="m-2">PRIVACY</a>
    </small>
 */ ?>
</footer>

<!-- jQuery and Bootstrap -->
<script src="/landing/js/jquery-3.2.1.min.js"></script>
<script src="/landing/js/bootstrap.bundle.min.js"></script>
<!-- Plugins JS -->
<script src="/landing/js/owl.carousel.min.js"></script>
<!-- Custom JS -->
<script src="/landing/js/script.js"></script>

</body>

</html>
