@extends('frontend.layouts.master')

@section('content')




    <!--=============================
        MENU END
    ==============================-->


    <!--=============================
        404 PAGE START
    ==============================-->
    <section class="fp__404">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-7 m-auto">
                    <div class="fp__404_text wow fadeInUp" data-wow-duration="1s">
                        <img src="{{ asset('frontend/images/404_img.png') }}" alt="404" class="img-fluid w-100">
                        <h2>That Page Doesn't Exist!</h2>
                        <p>Sorry, the page you were looking for could not be found.</p>
                        <a class="common_btn" href="index.html">home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        404 PAGE END
    ==============================-->


    <!--=============================
        FOOTER START
    ==============================-->
    @endsection
