@extends('layouts.admin')

@section('title', 'Pick List')

@section('styles')
    <link rel="stylesheet" href="/theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        #sports-list {
            margin: 15px 0;
            list-style-type: none;
            display: flex;
            align-items: center;
        }
        #sports-list >li {
            border: 2px solid #000;
            margin: 0 10px;
            padding: 10px;
            border-radius: 25px;
            background: #fff;
            text-align: center;
            height: 150px;
            width: 150px;
        }
        #sports-list >li img {
            width: 100%;
            cursor: pointer;
        }
        #sports-list > li:hover {
            border: 2px solid #0ca5ff;
            transform: scale(1.1);
        }
        .list li img.active, .list li div.active {
            box-shadow: 0 0 11px rgb(33 33 33 / 20%);
            border-radius: 8px;
            border: 2pxsolid #0ca5ff;
            transform: scale(1.1);
        }
        table.pick-list {
            white-space: nowrap !important;
        }
        table.pick-list th, td {
            padding: 7px !important;
        }

        .table thead th {
            border-bottom: 2px solid #e6e6f2;
        }
        .odds-hover{
            padding: 5px;
            border: 1px solid transparent;
            cursor: pointer;
        }
        .odds-hover:hover, .odds-hover:active{
            border: 1px solid red;
            border-radius: 5px !important;
            background: #faebd7;
        }

        table.pick-list thead th {
            color: #1b1e21;
            background-color: #d6d8d9;
            border-color: #c6c8ca;
            text-transform: none !important;
            vertical-align: middle !important;
        }
        .multi-price {
            display: inline-block;
            height: 35px;
            border-left: 1px solid #555;
        }
        .picks-input-text {
            display: inline !important;
            padding: 2px 10px!important;
            font-size: 14px !important;
            border: 2px     solid #555;
            width: 25% !important;
        }
        .display-none {
            display: none !important;
        }
        .display-block {
            display: block !important;
        }
        .font-bold {
            font-weight: bold !important;
        }
        .text-dark {
            color: #3d405c !important;
        }
        .p-l-10 {
            padding-left: 10px !important;
        }
        .fs-14 {
            font-size: 14px !important;
        }
        .fs-11 {
            font-size: 11px !important;
        }
        .pull-right {
            float: right !important;
        }
        .btn-sm {
            padding: 5px 12px;
            font-size: 14px;
        }
        .m-b-10 {
            margin-bottom: 10px !important;
        }
        textarea.form-control {
            height: auto;
            color: #71748d;
            background-color: #fff;
            background-image: none;
            border: 1px solid #d2d2e4;
            border-radius: 2px;
            padding: 12px 16px;
        }
        .waiting-overlay {
            position: fixed;
            z-index: 9999999999;
            opacity: 1;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba( 255, 255, 255, .5 ) url(/images/hourglass.gif) 50% 50% no-repeat;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="sport-list-container">
                            <ul id="sports-list">
                                @foreach($sports_list as $sport)
                                    <li>
                                        @if ($sport->sport_image != '' && !is_null($sport->sport_image))
                                            <img class="img-sport"
                                                data-leagueid="{{ $sport->league_id }}"
                                                data-sportid="{{ $sport->sport_id }}"
                                                data-leagueabbreviation="{{ $sport->league_abbreviation }}"
                                                alt="{{ $sport->league_name;}}"
                                                src="{{ asset("assets/gfx/{$sport->sport_image}") }}"
                                            >
                                        @else
                                            <div class="no-img-div"
                                                data-leagueid="{{ $sport->league_id }}"
                                                data-sportid="{{ $sport->sport_id }}"
                                                data-leagueabbreviation="{{ $sport->league_abbreviation }}">
                                                <span
                                                    data-leagueid="{{ $sport->league_id }}"
                                                    data-sportid="{{ $sport->sport_id }}"
                                                    data-leagueabbreviation="{{ $sport->league_abbreviation }}"
                                                >
                                                    {{ strtoupper($sport->league_abbreviation) }}
                                                </span>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="pick-content"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalTitle"></h5>
                </div>
                <div class="modal-body">
                    <p id="p_body"></p>
                </div>
                <div class="modal-footer text-center">
                    <a href="#" class="btn btn-success btn-fill" id="btn_modal_ok" data-dismiss="modal">Ok</a>
                    <a href="#" class="btn btn-danger btn-fill" id="btn_modal_close" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
    <div class="waiting-overlay"></div>
@endsection
@section('scripts')
    <script src="/theme/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/theme/plugins/jszip/jszip.min.js"></script>
    <script src="/theme/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/theme/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/theme/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    {{-- Update tiny MCE token --}}
    <script src="https://cdn.tiny.cloud/1/3zpkljyc3pdgxy2ostlu1wbq3mfaytk4na1yfotao86t1bxb/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            $('.waiting-overlay').hide();
            sessionStorage.setItem('multi_count', 0);
            sessionStorage.removeItem('integrity_list');
            sessionStorage.removeItem('multi_picks_data');

            var publish_details =
                `<tr class="display-none publish-details">
                    <td colspan="7" style="padding: 20px !important;">
                        <div class="row" style="border-top: 2px solid #aaa;">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12 m-t-10 title display-none">
                                        <div class="form-group">
                                            <label class="col-form-label" style="padding-left: 0px !important;text-align: left;">Title<span style="color: red;">*</span></label>
                                            <input type="text" class="pick-title-input form-control" placeholder="Please enter title here..."/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 m-t-10 teaser display-none">
                                        <div class="form-group">
                                            <label class="col-form-label col-md-12" style="padding-left: 0px !important;text-align: left;">Teaser<span style="color: red;">*</span></label>
                                            <textarea class="pick-teaser-input form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 m-t-37 text-center">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-continue-multi display-none m-r-5 col-md-3 mt-3"><i class="fas fa-play"></i> Continue</button>
                                            <button class="btn btn-success btn-publish display-none col-md-3 mt-3"><i class="fas fa-upload"></i> Publish</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 m-t-20 analysis display-none">
                                        <div class="form-group">
                                            <label class="col-form-label col-md-12" style="padding-left: 0px !important;text-align: left;">Analysis<span style="color: red;">*</span></label>
                                            <textarea class="pick-analysis-input col-md-10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>`;


            window.multi_sports = function() {
                $('.waiting-overlay').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('getSportsSchedleMulti') }}",
                    type: "POST",
                    data: {rotations: sessionStorage.getItem('rotations')},
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.addEventListener("progress", function(evt) {
                            $('.pick-content').html('<div class="card"><div class="card-body" style="padding: 5px !important;">'+evt.target.response+'</div></div>');
                        }, false);

                        return xhr;
                    },
                    success:function(success)
                    {
                        $('.waiting-overlay').hide();
                        $('.pick-content').html('<div class="card"><div class="card-body">'+success+'</div></div>');
                        sessionStorage.removeItem('rotations');

                        sessionStorage.setItem('multi_count', 0);
                        sessionStorage.removeItem('integrity_list');
                        sessionStorage.removeItem('multi_picks_data');
                        var table_id = '';

                        // $(".multi-price-input, .single-price-input").inputmask("$99");
                        $(".multi-price-input, .single-price-input").val(5);

                        // START MULTI CHECKBOX CHANGE EVENT
                        $('.start-multi-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            var id = $(e.target).attr('id');
                            $(e.target).parents('table').find('.publish-details').addClass('display-none');
                            if ($(e.target).is(':checked')) {
                                $('.start-multi-input').each(function() {
                                    if (id != $(this).attr('id') && !$(this).is(':checked')) {
                                        $(this).parent().parent().find('.start-multi-label').text('ADD MULTI');
                                    }
                                });

                                $(e.target).parents('tr').find('.multi-price').removeClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').addClass('showed');
                                $(e.target).parents('tr').find('.make-solo-label').text('ALLOW SOLO');
                                $(e.target).parents('tr').find('.make-solo-input').prop('disabled', false);

                                $(e.target).parents('table').find('.single-price').addClass('display-none');

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null) {
                                        if (typeof multi_count != 'NaN' && multi_count >= 1) {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                        } else {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                        }
                                    } else {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                } else {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null)
                                    {
                                        if (typeof multi_count != 'NaN' && multi_count >= 1)
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                        }
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                            }
                            else
                            {
                                $(e.target).parent().parent().find('.make-solo-input').prop('disabled', true);
                                $(e.target).parent().parent().find('.make-solo-input').prop('checked', false);
                                $(e.target).parent().parent().find('.multi-price').addClass('display-none');
                                $(e.target).parent().parent().find('.multi-price-input').removeClass('showed');
                                $(e.target).parents('table').find('.single-price').removeClass('display-none');
                                $(e.target).parents('table').find('.make-solo-label').text('MAKE SOLO');
                                $(e.target).parents('table').find('.btn-continue-multi').addClass('display-none');
                                // $(e.target).parents('table').find('.btn_continue').addClass('display-none');
                                if ($('.start-multi-input:checked').length == 0)
                                {
                                    $('.multi-price-input').prop('disabled', false);
                                    $('.start-multi-label').text('START MULTI');
                                    $('.multi-price-input').each(function() {
                                        if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                        {
                                            $(this).val(0);
                                            $(this).parents('table').find('.single-price-input').val(0);
                                        }
                                        else
                                        {
                                            $(this).val(5);
                                            $(this).parents('table').find('.single-price-input').val(5);
                                        }
                                    });
                                }

                                if ($('.start-multi-input:checked').length > 0 && !$(e.target).parents('tr').find('.multi-price-input').prop('disabled'))
                                {
                                    $('.start-multi-input').each(function() {
                                        if (id != $(this).attr('id') && $(this).parents('tr').find('.multi-price-input').hasClass('showed') && $(this).is(':checked') && !$(this).parents('tr').find('.make-solo-input').is(':checked'))
                                        {
                                            $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                            return false;
                                        }
                                    });
                                }

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null)
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                                else
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null)
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                            }

                        });

                        var m_price = 5;
                        var s_price = 5;

                        // MULTI PRICE TEXTBOX EVENT
                        $('.multi-price-input').keyup(function(e) {
                            if ($(e.target).parents('tr').find('.make-free-input').is(':checked'))
                            {
                                $(e.target).val(0);
                                m_price = 0;
                            }
                            else
                            {
                                $('.multi-price-input').each(function() {
                                    if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                    {
                                        $(this).val(0);
                                    }
                                    else
                                    {
                                        $(this).val($(e.target).val());
                                    }
                                });

                                m_price = $(e.target).val();
                            }
                        });

                        $('.multi-price-input').focusin(function() {
                            $(this).select();
                        });

                        $('.single-price-input').focusin(function() {
                            $(this).select();
                        });

                        // MULTI PRICE TEXTBOX ON BLUR EVENT
                        $('.multi-price-input').blur(function() {
                            var id = $(this).attr('id');

                            $('.multi-price-input').prop('disabled', true);

                            if ($(this).val() != '' && $(this).val() != null)
                            {
                                $('.multi-price-input').each(function() {
                                    if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                    {
                                        $(this).prop('disabled', false);
                                    }
                                });

                                $('.multi-price-input').each(function() {
                                    if (!$(this).parents('tr').find('.make-free-input').is(':checked') && $(this).parents('tr').find('.start-multi-input').is(':checked'))
                                    {
                                        $(this).prop('disabled', false);
                                        return false;
                                    }
                                });

                                $(this).prop('disabled', false);

                                if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                {
                                    $(this).val(0);
                                    m_price = 0;
                                }
                                else
                                {
                                    if (parseInt($(this).val()) < 5 || parseInt($(this).val()) > 99)
                                    {
                                        $(this).val(5);
                                        m_price = 5;
                                        showNotification('alert-warning', 'Price must between the range of $5 - $99', 'top', 'right', 'animated fadeInDown', 'animated fadeOutUp');
                                    }
                                }
                            }
                            else
                            {
                                if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                {
                                    $(this).val(0);
                                    m_price = 0;
                                }
                                else
                                {
                                    $(this).val(5);
                                    m_price = 5;
                                }
                            }

                        });

                        // MULTI PRICE TEXTBOX ON KEYPRESS EVENT
                        $('.multi-price-input').keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
                            {
                                return false;
                            }
                        });

                        // SINGLE TEXTBOX ON KEYPRESS EVENT
                        $('.single-price-input').keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
                            {
                                return false;
                            }
                        });

                        // SINGLE TEXTBOX ON KEYUP EVENT
                        $('.single-price-input').keyup(function() {
                            if ($(this).parents('table').find('.make-free-input').is(':checked'))
                            {
                                $(this).val(0);
                            }
                        });

                        // SINGLE PRICE TEXTBOX ON BLUR EVENT
                        $('.single-price-input').blur(function() {
                            if ($(this).val() != '' && $(this).val() != null)
                            {

                                if ($(this).parents('table').find('.make-free-input').is(':checked'))
                                {
                                    $(this).val(0);
                                    s_price = 0;
                                }
                                else
                                {
                                    if (parseInt($(this).val()) < 5 || parseInt($(this).val()) > 99)
                                    {
                                        $(this).val(5);
                                        s_price = 5;
                                        showNotification('alert-warning', 'Price must between the range of $5 - $99', 'top', 'right', 'animated fadeInDown', 'animated fadeOutUp');
                                    }
                                }
                            }
                            else
                            {
                                if ($(this).parents('table').find('.make-free-input').is(':checked'))
                                {
                                    $(this).val(0);
                                    s_price = 0;
                                }
                                else
                                {
                                    $(this).val(5);
                                    s_price = 5;
                                }
                            }

                        });

                        // MAKE SOLO CHECKBOX CHANGE EVENT
                        $('.make-solo-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).is(':checked'))
                            {
                                $(e.target).parents('tr').find('.multi-price').addClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').removeClass('showed');
                                $(e.target).parents('table').find('.single-price').removeClass('display-none');
                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null)
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                                else
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null)
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }

                                $('.start-multi-input').each(function() {
                                    if ($(this).parents('tr').find('.multi-price-input').hasClass('showed') && $(this).is(':checked') && !$(this).parents('tr').find('.make-solo-input').is(':checked'))
                                    {
                                        $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                        // return false;
                                    }
                                });
                            }
                            else
                            {

                                $(e.target).parents('tr').find('.multi-price').removeClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').addClass('showed');
                                $(e.target).parents('table').find('.single-price').addClass('display-none');

                                $('.start-multi-input').each(function() {
                                    if ($(this).parents('tr').find('.multi-price-input').hasClass('showed') && !$(this).parents('tr').find('.make-solo-input').is(':checked'))
                                    {
                                        $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                        // return false;
                                    }
                                });

                                if ($(e.target).parents('tr').find('.start-multi-input').is(':checked'))
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                                    {
                                        if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null)
                                        {
                                            if (typeof multi_count != 'NaN' && multi_count >= 1)
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                            }
                                            else
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            }
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        }
                                    }
                                    else
                                    {
                                        if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null)
                                        {
                                            if (typeof multi_count != 'NaN' && multi_count >= 1)
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                            }
                                            else
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            }
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        }
                                    }
                                }
                                else
                                {

                                }

                                // $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                            }
                        });

                        // FREE CHECKBOX CHANGE EVENT
                        $('.make-free-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            var table_id        = $(e.target).parents('table').attr('id');
                            if ($(e.target).is(':checked'))
                            {
                                $(e.target).parents('table').find('.single-price-input').val(0);
                                $(e.target).parents('table').find('.multi-price-input').val(0);
                                $(e.target).parents('table').find('.teaser').addClass('display-none');
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                $('.multi-price-input').prop('disabled', false);

                                if (typeof multi_count != 'NaN' && multi_count >= 1)
                                {
                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                }
                                else
                                {
                                    if ($(e.target).parents('tr').find('.start-multi-input').is(':checked'))
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                }

                                $(e.target).parents('table').find('.rating-type-select').html('<option value="FREE">FREE</option>');

                                $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').prop('disabled', true);
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val('');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').prop('disabled', true);
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val('');

                                $(e.target).parents('table').find('tr.active-row').find('.tplay').addClass('display-none');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title').addClass('display-none');
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('getRatingNumber') }}",
                                    type: 'POST',
                                    data: {rating_type: 'FREE'},
                                    success: function(success) {
                                        var jsonData = JSON.parse(success);
                                        console.log()

                                        if (jsonData.status_code == 200)
                                        {
                                            var rating_number_option = '';
                                            for(var i=0; i<jsonData.result.length; i++)
                                            {
                                                rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                            }

                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                        }
                                    }
                                });
                            }
                            else
                            {
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                $(e.target).parents('table').find('.single-price-input').val(s_price);
                                $(e.target).parents('table').find('.multi-price-input').val(m_price);
                                // $('.multi-price-input').prop('disabled', true);
                                $(e.target).parents('tr').find('.multi-price-input').prop('disabled', false);
                                $(e.target).parents('table').find('.btn_save').addClass('display-none');
                                $(e.target).parents('table').find('.btn_continue').addClass('display-none');
                                $(e.target).parents('table').find('.publish-details').addClass('display-none');

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('getRatingType') }}",
                                    type: 'POST',
                                    success: function(success) {
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');

                                        $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                    }
                                });

                            }
                        });

                        // SELECTED DETAILS CLICK EVENT
                        $(document).on('click', '.selected-details', function(e) {
                            $(e.target).parents('table').find('.start-multi-input').prop('disabled', true);
                            if (('integrity_list' in sessionStorage)) {
                                var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                var list_array = Object.values(list);

                                if (list_array.indexOf($(e.target).parents('td').data('integrityid')) === -1) {
                                    table_id = $(e.target).parents('table').attr('id');
                                    $(e.target).parents('table').find('.active-details').removeClass('active-details');
                                    $(e.target).parents('table').find('.active-row').removeClass('active-row');
                                    $(e.target).parents('td').addClass('active-details');
                                    $(e.target).parents('tr').next('tr').addClass('active-row');
                                    $(e.target).parents('tr').next('tr').find('.selected-header').text($(e.target).data('head'));
                                    $(e.target).parents('tr').next('tr').find('.selected-header-input').val($(e.target).data('head'));
                                    $(e.target).parents('tr').next('tr').find('.selected-juice-input').val($(e.target).data('juice'));
                                    $(e.target).parents('tr').next('tr').find('.selected-value').text($(e.target).data('value'));
                                    $(e.target).parents('tr').next('tr').find('.selected-value-input').val($(e.target).data('value'));
                                    $(e.target).parents('tr').next('tr').find('.selected-integrity-id').val($(e.target).parents('td').data('integrityid'));
                                    $(e.target).parents('tr').next('tr').removeClass('display-none');
                                    $(e.target).parents('table').find('.game-info').addClass('display-none');

                                    if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{ route('getRatingNumber') }}",
                                            type: 'POST',
                                            data: {rating_type: 'FREE'},
                                            success: function(success) {
                                                var jsonData = JSON.parse(success);

                                                if (jsonData.status_code == 200) {
                                                    var rating_number_option = '';
                                                    for(var i=0; i<jsonData.result.length; i++) {
                                                        rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                                    }

                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                                } else {
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                                }

                                                if (($(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || (!$(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || ($(e.target).parents('table').find('.make-solo-input').is(':checked') && $(e.target).parents('table').find('.start-multi-input').is(':checked'))) {
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                                } else {
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                }
                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{ route('getRatingType') }}",
                                            type: 'POST',
                                            success: function(success) {
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');

                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                            }
                                        });
                                    }

                                    if ($(e.target).parents('tbody').find('.publish-details').length == 0) {
                                        $(e.target).parents('tbody').append(publish_details);
                                        $(e.target).parents('table').find('.pick-title-input').attr('id', 'pick_title_'+table_id);
                                        $(e.target).parents('table').find('.pick-teaser-input').attr('id', 'pick_teaser_'+table_id);
                                        $(e.target).parents('table').find('.pick-analysis-input').attr('id', 'pick_anaylysis_'+table_id);
                                    }

                                    tinymce.init({
                                        selector: 'textarea',
                                        // placeholder: "Please enter teaser here...",
                                        height: "300",
                                        width: "auto",
                                        themes: "modern",
                                        menubar: true,
                                        menu: {
                                            file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                                            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                                            view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                                            insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                                            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                                            tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                                            table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                                            help: { title: 'Help', items: 'help' }
                                        },
                                        plugins: [
                                            'advlist autolink lists link image charmap print preview anchor textcolor',
                                            'searchreplace visualblocks code fullscreen',
                                            'insertdatetime media table contextmenu paste code help wordcount image imagetools'
                                        ],
                                        toolbar: 'media link image table | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                    });
                                } else {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Integrity Validation');
                                    $('#p_body').html('Element integrity has been violated! Unable to continue this action.');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }

                            }
                            else
                            {
                                table_id = $(e.target).parents('table').attr('id');
                                $(e.target).parents('table').find('.active-details').removeClass('active-details');
                                $(e.target).parents('table').find('.active-row').removeClass('active-row');
                                $(e.target).parents('td').addClass('active-details');
                                $(e.target).parents('tr').next('tr').addClass('active-row');
                                $(e.target).parents('tr').next('tr').find('.selected-header').text($(e.target).data('head'));
                                $(e.target).parents('tr').next('tr').find('.selected-header-input').val($(e.target).data('head'));
                                $(e.target).parents('tr').next('tr').find('.selected-juice-input').val($(e.target).data('juice'));
                                $(e.target).parents('tr').next('tr').find('.selected-value').text($(e.target).data('value'));
                                $(e.target).parents('tr').next('tr').find('.selected-value-input').val($(e.target).data('value'));
                                $(e.target).parents('tr').next('tr').find('.selected-integrity-id').val($(e.target).parents('td').data('integrityid'));
                                $(e.target).parents('tr').next('tr').removeClass('display-none');
                                $(e.target).parents('table').find('.game-info').addClass('display-none');

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route('getRatingNumber') }}",
                                        type: 'POST',
                                        data: {rating_type: 'FREE'},
                                        success: function(success) {
                                            var jsonData = JSON.parse(success);

                                            if (jsonData.status_code == 200)
                                            {
                                                var rating_number_option = '';
                                                for(var i=0; i<jsonData.result.length; i++)
                                                {
                                                    rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                                }

                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                            }
                                            else
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                            }

                                            if (($(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || (!$(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || ($(e.target).parents('table').find('.make-solo-input').is(':checked') && $(e.target).parents('table').find('.start-multi-input').is(':checked')))
                                            {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                            }
                                            else
                                            {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            }
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route('getRatingType') }}",
                                        type: 'POST',
                                        success: function(success) {
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');

                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                        }
                                    });
                                }

                                if ($(e.target).parents('tbody').find('.publish-details').length == 0) {
                                    $(e.target).parents('tbody').append(publish_details);
                                    $(e.target).parents('table').find('.pick-title-input').attr('id', 'pick_title_'+table_id);
                                    $(e.target).parents('table').find('.pick-teaser-input').attr('id', 'pick_teaser_'+table_id);
                                    $(e.target).parents('table').find('.pick-analysis-input').attr('id', 'pick_anaylysis_'+table_id);
                                }

                                tinymce.init({
                                    selector: 'textarea',
                                    // placeholder: "Please enter teaser here...",
                                    height: "300",
                                    width: "auto",
                                    themes: "modern",
                                    menubar: true,
                                    menu: {
                                        file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                                        edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                                        view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                                        insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                                        format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                                        tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                                        table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                                        help: { title: 'Help', items: 'help' }
                                    },
                                    plugins: [
                                    'advlist autolink lists link image charmap print preview anchor textcolor',
                                    'searchreplace visualblocks code fullscreen',
                                    'insertdatetime media table contextmenu paste code help wordcount image imagetools'
                                    ],
                                    toolbar: 'media link image table | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                });
                            }

                            return false;
                        });

                        // BUTTON RESET CLICK EVENT
                        $('.btn_reset_selected_pick').click(function() {
                            $(this).parents('tr').addClass('display-none');
                            $(this).parents('table').find('.game-info').removeClass('display-none');
                            $(this).parents('table').find('.publish-details').addClass('display-none');
                            $(this).parents('table').find('.start-multi-input').prop('disabled', false);
                        });

                        // RATING TYPE SELECT OPTION CHANGE EVENT
                        $('.rating-type-select').change(function(e) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{ route('getRatingNumber') }}",
                                type: 'POST',
                                data: {rating_type: $(e.target).val()},
                                success: function(success) {
                                    var jsonData = JSON.parse(success);

                                    if (jsonData.status_code == 200)
                                    {
                                        var rating_number_option = '';
                                        for(var i=0; i<jsonData.result.length; i++)
                                        {
                                            rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                        }

                                        $(e.target).parents('tr').find('.rating-number-select').prop('disabled', false);
                                        $(e.target).parents('tr').find('.rating-number-select').html(rating_number_option);

                                        var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                                        if ($(e.target).val() == 'TOPPLAY')
                                        {
                                            $(e.target).parents('tr').find('.tplay-designation-select').prop('disabled', false);
                                            $(e.target).parents('tr').find('.tplay').removeClass('display-none');
                                            $(e.target).parents('tr').find('.tplay-title-select').prop('disabled', false);
                                            $(e.target).parents('tr').find('.tplay-title').removeClass('display-none');
                                            $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                            $(e.target).parents('table').find('.publish-details').addClass('display-none');
                                        }
                                        else
                                        {
                                            $(e.target).parents('tr').find('.tplay-designation-select').prop('disabled', true);
                                            $(e.target).parents('tr').find('.tplay-designation-select').val('');
                                            $(e.target).parents('tr').find('.tplay-title-select').prop('disabled', true);
                                            $(e.target).parents('tr').find('.tplay-title-select').val('');

                                            $(e.target).parents('tr').find('.tplay').addClass('display-none');
                                            $(e.target).parents('tr').find('.tplay-title').addClass('display-none');

                                            if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked'))
                                            {
                                                $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                                $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                            }
                                            else
                                            {
                                                if (typeof multi_count != 'NaN' && multi_count >= 1)
                                                {
                                                    $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                                    $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                                }
                                                else
                                                {
                                                    $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                                    $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $(e.target).parents('tr').find('.rating-number-select').prop('disabled', true);
                                        $(e.target).parents('tr').find('.rating-number-select').html('');
                                    }
                                }
                            });
                        });

                        // BUTTON SAVE CLICK EVENT
                        $('.btn_save').click(function(e) {
                            // var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-details').length > 0)
                            {
                                if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == null)
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign pitcher first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                            {
                                if ($(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == null || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == null)
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign T-Play designation and T-Play title first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            $(e.target).parents('table').find('.publish-details').removeClass('display-none');
                            $(e.target).parents('table').find('.title').removeClass('display-none');

                            if ($(e.target).parents('table').find('.make-free-input').is(':checked'))
                            {
                                $(e.target).parents('table').find('.teaser').addClass('display-none');
                            }
                            else
                            {
                                $(e.target).parents('table').find('.teaser').removeClass('display-none');
                            }

                            $(e.target).parents('table').find('.analysis').removeClass('display-none');

                            $(e.target).parents('table').find('.btn-publish').removeClass('display-none');
                            $(e.target).parents('table').find('.btn-continue-multi').addClass('display-none');
                            $(e.target).parents('table').find('.pick-title-input').prop('disabled', false);
                            tinymce.get('pick_teaser_'+table_id).mode.set("design");
                        });

                        // TPLAY TITLE CHANGE EVENT
                        $('.tplay-title-select').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).val() != '')
                            {
                                if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked'))
                                {
                                    $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                    $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                }
                                else
                                {
                                    if (typeof multi_count != 'NaN' && multi_count >= 1)
                                    {
                                        $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                        $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                        $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                    }

                                }
                            }
                        });

                        // Publish Details Validation
                        $('table').on('click', '.btn-publish', function(e) {

                            if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked'))
                            {
                                var pick_title      = $(e.target).parents('tr').find('.pick-title-input').val();
                                var pick_teaser     = tinymce.get('pick_teaser_'+table_id).getContent();
                                var pick_anaylysis  = tinymce.get('pick_anaylysis_'+table_id).getContent();

                                var sport_id        = $(e.target).parents('table').data('sportid');
                                var league_id       = $(e.target).parents('table').data('leagueid');
                                var price           = $(e.target).parents('table').find('tr.active-row').find('.single-price-input').val();

                                var event_id        = $(e.target).parents('table').attr('id');
                                var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();
                                if (parseInt(sport_id) == 3 && parseInt(league_id) == 5)
                                {
                                    var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                }
                                else
                                {
                                    var pitcher     = '';
                                }

                                if (rating_type == 'TOPPLAY')
                                {
                                    var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                    var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                }
                                else
                                {
                                    var tplay_designation   = '';
                                    var tplay_title         = '';
                                }

                                var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                var picksData = [{
                                            pick_title: pick_title,
                                            pick_teaser: pick_teaser,
                                            pick_anaylysis: pick_anaylysis,
                                            sport_id: sport_id,
                                            league_id: league_id,
                                            price: price,
                                            event_id: event_id,
                                            rating_type: rating_type,
                                            rating_number: rating_number,
                                            pitcher: pitcher,
                                            tplay_designation: tplay_designation,
                                            tplay_title: tplay_title,
                                            selected_element: selected_element,
                                            selected_juice: selected_juice,
                                            element_value: element_value,
                                            rot_id: rot_id,
                                            side: side,
                                            team_name: team_name,
                                            event_datetime: event_datetime,
                                            ticket_type: 1,
                                        }];

                                console.log('picksData1', picksData)

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked'))
                                {
                                    if (pick_title == '' || pick_title == null || pick_anaylysis == '' || pick_anaylysis == null)
                                    {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('Please fill all needed information!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                }
                                else
                                {
                                    if (pick_title == '' || pick_title == null || pick_teaser == '' || pick_teaser == null || pick_anaylysis == '' || pick_anaylysis == null)
                                    {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('Please fill all needed information!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                }

                                if (('integrity_list' in sessionStorage))
                                {
                                    var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                    var list_array = Object.values(list);

                                    list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                    sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                }
                                else
                                {
                                    sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                }

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('saveNewPick') }}",
                                    type: 'POST',
                                    data: {picks_data: picksData, group_key: getRandomString(6)},
                                    success: function(success)
                                    {
                                        var jsonData = JSON.parse(success);
                                        if (jsonData.status_code == 200)
                                        {

                                            $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                            $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                            $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                            $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                            $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');
                                            $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                            $(e.target).parents('tr').find('.pick-title-input').val('');
                                            tinymce.get('pick_teaser_'+table_id).setContent('');
                                            tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                            if ($(e.target).parents('table').find('.make-free-input').is(':checked'))
                                            {
                                                $(e.target).parents('table').find('.multi-price-input').val(0);
                                                $(e.target).parents('table').find('.single-price-input').val(0);
                                            }
                                            else
                                            {
                                                $(e.target).parents('table').find('.multi-price-input').val(5);
                                                $(e.target).parents('table').find('.single-price-input').val(5);
                                            }

                                            $(e.target).parents('table').find('.rating-type-select').val('');
                                            $(e.target).parents('table').find('.rating-number-select').html('');
                                            $(e.target).parents('table').find('.pitcher-select').val('');
                                            $(e.target).parents('table').find('.tplay-designation-select').val('');
                                            $(e.target).parents('table').find('.tplay-title-select').val('');

                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Success');
                                            $('#p_body').html(jsonData.status_message);
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });
                                        }
                                        else
                                        {
                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Error');
                                            $('#p_body').html('Internal Server Error');
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });
                                        }
                                    },
                                    error: function(error)
                                    {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Error');
                                        $('#p_body').html('Internal Server Error');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });
                                    }
                                });
                            }
                            else
                            {
                                if (('multi_picks_data' in sessionStorage))
                                {
                                    var multi_picks_data_list = JSON.parse(sessionStorage.getItem('multi_picks_data'));
                                    var multi_picks_data = Object.values(multi_picks_data_list);

                                    if (multi_picks_data.length > 0)
                                    {
                                        var tbl_id          = $(e.target).parents('table').attr('id');
                                        var pick_title      = $(e.target).parents('table').find('.pick-title-input').val();
                                        var pick_teaser     = tinymce.get('pick_teaser_'+tbl_id).getContent();
                                        var pick_anaylysis  = tinymce.get('pick_anaylysis_'+tbl_id).getContent();

                                        var sport_id        = $(e.target).parents('table').data('sportid');
                                        var league_id       = $(e.target).parents('table').data('leagueid');

                                        var price           = $(e.target).parents('table').find('.multi-price-input').val();

                                        var event_id        = $(e.target).parents('table').attr('id');
                                        var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                        var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();
                                        if (parseInt(sport_id) == 3 && parseInt(league_id) == 5)
                                        {
                                            var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                        }
                                        else
                                        {
                                            var pitcher     = '';
                                        }

                                        if (rating_type == 'TOPPLAY')
                                        {
                                            var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                            var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                        }
                                        else
                                        {
                                            var tplay_designation   = '';
                                            var tplay_title         = '';
                                        }

                                        var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                        var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                        var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                        var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                        var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                        var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                        var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                        if (pick_title == '' || pick_title == null || pick_teaser == ''|| pick_teaser == null || pick_anaylysis == '' || pick_anaylysis == null)
                                        {
                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Publish Details Validation');
                                            $('#p_body').html('Please fill all needed information!');
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });

                                            return false;
                                        }
                                        else
                                        {

                                            var picksData = {
                                                pick_title: pick_title,
                                                pick_teaser: pick_teaser,
                                                pick_anaylysis: pick_anaylysis,
                                                sport_id: sport_id,
                                                league_id: league_id,
                                                price: price,
                                                event_id: event_id,
                                                rating_type: rating_type,
                                                rating_number: rating_number,
                                                pitcher: pitcher,
                                                tplay_designation: tplay_designation,
                                                tplay_title: tplay_title,
                                                selected_element: selected_element,
                                                selected_juice: selected_juice,
                                                element_value: element_value,
                                                rot_id: rot_id,
                                                side: side,
                                                team_name: team_name,
                                                event_datetime: event_datetime,
                                                ticket_type: 2
                                            };

                                            multi_picks_data.push(picksData);
                                            sessionStorage.setItem('multi_picks_data', JSON.stringify(multi_picks_data));

                                            if (('integrity_list' in sessionStorage))
                                            {
                                                var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                                var list_array = Object.values(list);

                                                list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                                sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                            }
                                            else
                                            {
                                                sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                            }

                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "{{ route('saveNewPick') }}",
                                                type: 'POST',
                                                data: {picks_data: multi_picks_data, group_key: getRandomString(6)},
                                                success: function(success)
                                                {
                                                    var jsonData = JSON.parse(success);
                                                    if (jsonData.status_code == 200)
                                                    {
                                                        $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                                        $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                                        $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                                        $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                                        $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');
                                                        $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                                        $(e.target).parents('tr').find('.pick-title-input').val('');
                                                        tinymce.get('pick_teaser_'+table_id).setContent('');
                                                        tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                                        if ($(e.target).parents('table').find('.make-free-input').is(':checked'))
                                                        {
                                                            $(e.target).parents('table').find('.multi-price-input').val(0);
                                                            $(e.target).parents('table').find('.single-price-input').val(0);
                                                        }
                                                        else
                                                        {
                                                            $(e.target).parents('table').find('.multi-price-input').val(5);
                                                            $(e.target).parents('table').find('.single-price-input').val(5);
                                                        }

                                                        $(e.target).parents('table').find('.rating-type-select').val('');
                                                        $(e.target).parents('table').find('.rating-number-select').html('');
                                                        $(e.target).parents('table').find('.pitcher-select').val('');
                                                        $(e.target).parents('table').find('.tplay-designation-select').val('');
                                                        $(e.target).parents('table').find('.tplay-title-select').val('');
                                                        sessionStorage.removeItem('multi_picks_data');
                                                        sessionStorage.setItem('multi_count', 0);

                                                        $('.start-multi-input').prop('checked', false);
                                                        $('.make-free-input').prop('checked', false);
                                                        $('.make-solo-input').prop('checked', false);
                                                        $('.multi-price').addClass('display-none');

                                                        $('.waiting-overlay').hide();
                                                        $('#btn_modal_close').show();
                                                        $('#btn_modal_ok').hide();
                                                        $('#alertModalTitle').html('Success');
                                                        $('#p_body').html(jsonData.status_message);
                                                        $('#alertModal').modal({
                                                            keyboard: false,
                                                            backdrop: 'static',
                                                            show: true
                                                        });
                                                    }
                                                    else
                                                    {
                                                        $('.waiting-overlay').hide();
                                                        $('#btn_modal_close').show();
                                                        $('#btn_modal_ok').hide();
                                                        $('#alertModalTitle').html('Error');
                                                        $('#p_body').html('Internal Server Error');
                                                        $('#alertModal').modal({
                                                            keyboard: false,
                                                            backdrop: 'static',
                                                            show: true
                                                        });
                                                    }
                                                },
                                                error: function(error)
                                                {
                                                    $('.waiting-overlay').hide();
                                                    $('#btn_modal_close').show();
                                                    $('#btn_modal_ok').hide();
                                                    $('#alertModalTitle').html('Error');
                                                    $('#p_body').html('Internal Server Error');
                                                    $('#alertModal').modal({
                                                        keyboard: false,
                                                        backdrop: 'static',
                                                        show: true
                                                    });
                                                }
                                            });
                                        }
                                    }
                                    else
                                    {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('No picks data found!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                }
                                else
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Publish Details Validation');
                                    $('#p_body').html('No picks data found!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }
                        });

                        $('.btn_continue').click(function(e) {
                            $(e.target).parents('table').find('.btn-publish').addClass('display-none');
                            $(e.target).parents('table').find('.btn-continue-multi').removeClass('display-none');

                            if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-details').length > 0)
                            {
                                if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == null)
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign pitcher first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                            {
                                if ($(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == null || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == null)
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign T-Play designation and T-Play title first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            $(e.target).parents('table').find('.analysis').removeClass('display-none');
                            $(e.target).parents('table').find('.publish-details').removeClass('display-none');
                            $(e.target).parents('table').find('.title').removeClass('display-none');
                            $(e.target).parents('table').find('.teaser').removeClass('display-none');
                            $(e.target).parents('table').find('.pick-title-input').prop('disabled', true);
                            tinymce.get('pick_teaser_'+table_id).mode.set("readonly");

                        });

                        // Continue Multi Button Click Event
                        $('table').on('click', '.btn-continue-multi', function(e) {

                            if (tinymce.get('pick_anaylysis_'+table_id).getContent() != '' && tinymce.get('pick_anaylysis_'+table_id).getContent() != null)
                            {
                                if (('integrity_list' in sessionStorage))
                                {
                                    var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                    var list_array = Object.values(list);

                                    list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                    sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                }
                                else
                                {
                                    sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                }

                                var tbl_id          = $(e.target).parents('table').attr('id');
                                var pick_title      = $(e.target).parents('table').find('.pick-title-input').val();
                                var pick_teaser     = tinymce.get('pick_teaser_'+tbl_id).getContent();
                                var pick_anaylysis  = tinymce.get('pick_anaylysis_'+tbl_id).getContent();

                                var sport_id        = $(e.target).parents('table').data('sportid');
                                var league_id       = $(e.target).parents('table').data('leagueid');

                                var price           = $(e.target).parents('table').find('.multi-price-input').val();

                                var event_id        = $(e.target).parents('table').attr('id');
                                var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();
                                if (parseInt(sport_id) == 3 && parseInt(league_id) == 5)
                                {
                                    var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                }
                                else
                                {
                                    var pitcher     = '';
                                }

                                if (rating_type == 'TOPPLAY')
                                {
                                    var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                    var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                }
                                else
                                {
                                    var tplay_designation   = '';
                                    var tplay_title         = '';
                                }

                                var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                var picksData = {
                                            pick_title: pick_title,
                                            pick_teaser: pick_teaser,
                                            pick_anaylysis: pick_anaylysis,
                                            sport_id: sport_id,
                                            league_id: league_id,
                                            price: price,
                                            event_id: event_id,
                                            rating_type: rating_type,
                                            rating_number: rating_number,
                                            pitcher: pitcher,
                                            tplay_designation: tplay_designation,
                                            tplay_title: tplay_title,
                                            selected_element: selected_element,
                                            selected_juice: selected_juice,
                                            element_value: element_value,
                                            rot_id: rot_id,
                                            side: side,
                                            team_name: team_name,
                                            event_datetime: event_datetime,
                                            ticket_type: 2
                                        };
                                        console.log('picksData3', picksData)

                                if (('multi_picks_data' in sessionStorage))
                                {
                                    var multi_picks_data_list = JSON.parse(sessionStorage.getItem('multi_picks_data'));
                                    var multi_picks_data = Object.values(multi_picks_data_list);
                                    multi_picks_data.push(picksData);
                                    sessionStorage.setItem('multi_picks_data', JSON.stringify(multi_picks_data));
                                }
                                else
                                {
                                    sessionStorage.setItem('multi_picks_data', JSON.stringify([picksData]));
                                }

                                var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                                if (typeof multi_count != 'NaN')
                                {
                                    multi_count+=1;
                                }
                                else
                                {
                                    multi_count=1;
                                }

                                sessionStorage.setItem('multi_count', multi_count);

                                $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');

                                $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                $(e.target).parents('tr').find('.pick-title-input').val('');
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked'))
                                {
                                    $(e.target).parents('table').find('.multi-price-input').val(0);
                                    $(e.target).parents('table').find('.single-price-input').val(0);
                                }
                                else
                                {
                                    $(e.target).parents('table').find('.multi-price-input').val(5);
                                    $(e.target).parents('table').find('.single-price-input').val(5);
                                }

                                $(e.target).parents('table').find('.rating-type-select').val('');
                                $(e.target).parents('table').find('.rating-number-select').html('');
                                $(e.target).parents('table').find('.pitcher-select').val('');
                                $(e.target).parents('table').find('.tplay-designation-select').val('');
                                $(e.target).parents('table').find('.tplay-title-select').val('');
                            }
                            else
                            {
                                $('.waiting-overlay').hide();
                                $('#btn_modal_close').show();
                                $('#btn_modal_ok').hide();
                                $('#alertModalTitle').html('Invalid Input');
                                $('#p_body').html('Please enter analysis info first!');
                                $('#alertModal').modal({
                                    keyboard: false,
                                    backdrop: 'static',
                                    show: true
                                });
                            }

                        });
                    },
                    error: function()
                    {
                        $('.waiting-overlay').hide();
                        $('#btn_modal_close').show();
                        $('#btn_modal_ok').hide();
                        $('#alertModalTitle').html('Error');
                        $('#p_body').html('An error occurred during action request!');
                        $('#alertModal').modal({
                            keyboard: false,
                            backdrop: 'static',
                            show: true
                        });
                    }
                });
            }

            if (('rotations' in sessionStorage)) {
                multi_sports();
            }

            $('.img-sport, .no-img-div, li div span').click(function(e) {
                console.log('requesting...');
                $('.waiting-overlay').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('getSportsSchedule') }}",
                    type: "POST",
                    data: {
                        league_id: $(e.target).data('leagueid'),
                        sport_id: $(e.target).data('sportid'),
                        league_abbreviation: $(e.target).data('leagueabbreviation')
                    },
                    success: function(data) {
                        sessionStorage.setItem('multi_count', 0);
                        sessionStorage.removeItem('integrity_list');
                        sessionStorage.removeItem('multi_picks_data');
                        var table_id = '';
                        $('.waiting-overlay').hide();

                        var dataHtml = data.replace(/\\/g, "");
                        $('.pick-content').html('<div class="card"><div class="card-body">'+data+'</div></div>');

                        $(".multi-price-input, .single-price-input").val(5);

                        // START MULTI CHECKBOX CHANGE EVENT
                        $('.start-multi-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            var id = $(e.target).attr('id');
                            $(e.target).parents('table').find('.publish-details').addClass('display-none');
                            if ($(e.target).is(':checked'))
                            {
                                $('.start-multi-input').each(function() {
                                    if (id != $(this).attr('id') && !$(this).is(':checked'))
                                    {
                                        $(this).parent().parent().find('.start-multi-label').text('ADD MULTI');
                                    }
                                });

                                $(e.target).parents('tr').find('.multi-price').removeClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').addClass('showed');
                                $(e.target).parents('tr').find('.make-solo-label').text('ALLOW SOLO');
                                $(e.target).parents('tr').find('.make-solo-input').prop('disabled', false);

                                $(e.target).parents('table').find('.single-price').addClass('display-none');

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY')
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null)
                                    {
                                        if (typeof multi_count != 'NaN' && multi_count >= 1)
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                        }
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                                else
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null)
                                    {
                                        if (typeof multi_count != 'NaN' && multi_count >= 1)
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                        }
                                        else
                                        {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                        }
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                            } else {
                                $(e.target).parent().parent().find('.make-solo-input').prop('disabled', true);
                                $(e.target).parent().parent().find('.make-solo-input').prop('checked', false);
                                $(e.target).parent().parent().find('.multi-price').addClass('display-none');
                                $(e.target).parent().parent().find('.multi-price-input').removeClass('showed');
                                $(e.target).parents('table').find('.single-price').removeClass('display-none');
                                $(e.target).parents('table').find('.make-solo-label').text('MAKE SOLO');
                                $(e.target).parents('table').find('.btn-continue-multi').addClass('display-none');
                                if ($('.start-multi-input:checked').length == 0) {
                                    $('.multi-price-input').prop('disabled', false);
                                    $('.start-multi-label').text('START MULTI');
                                    $('.multi-price-input').each(function() {
                                        if ($(this).parents('tr').find('.make-free-input').is(':checked'))
                                        {
                                            $(this).val(0);
                                            $(this).parents('table').find('.single-price-input').val(0);
                                        }
                                        else
                                        {
                                            $(this).val(5);
                                            $(this).parents('table').find('.single-price-input').val(5);
                                        }
                                    });
                                }

                                if ($('.start-multi-input:checked').length > 0 && !$(e.target).parents('tr').find('.multi-price-input').prop('disabled')) {
                                    $('.start-multi-input').each(function() {
                                        if (id != $(this).attr('id') && $(this).parents('tr').find('.multi-price-input').hasClass('showed') && $(this).is(':checked') && !$(this).parents('tr').find('.make-solo-input').is(':checked')) {
                                            $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                            return false;
                                        }
                                    });
                                }

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null) {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    } else {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                } else {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null) {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    } else {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                            }

                        });

                        var m_price = 5;
                        var s_price = 5;

                        // MULTI PRICE TEXTBOX EVENT
                        $('.multi-price-input').keyup(function(e) {
                            if ($(e.target).parents('tr').find('.make-free-input').is(':checked')) {
                                $(e.target).val(0);
                                m_price = 0;
                            } else {
                                $('.multi-price-input').each(function() {
                                    if ($(this).parents('tr').find('.make-free-input').is(':checked')) {
                                        $(this).val(0);
                                    } else {
                                        $(this).val($(e.target).val());
                                    }
                                });

                                m_price = $(e.target).val();
                            }
                        });

                        $('.multi-price-input').focusin(function() {
                            $(this).select();
                        });

                        $('.single-price-input').focusin(function() {
                            $(this).select();
                        });

                        // MULTI PRICE TEXTBOX ON BLUR EVENT
                        $('.multi-price-input').blur(function() {
                            var id = $(this).attr('id');

                            $('.multi-price-input').prop('disabled', true);

                            if ($(this).val() != '' && $(this).val() != null) {
                                $('.multi-price-input').each(function() {
                                    if ($(this).parents('tr').find('.make-free-input').is(':checked')) {
                                        $(this).prop('disabled', false);
                                    }
                                });

                                $('.multi-price-input').each(function() {
                                    if (!$(this).parents('tr').find('.make-free-input').is(':checked') && $(this).parents('tr').find('.start-multi-input').is(':checked')) {
                                        $(this).prop('disabled', false);
                                        return false;
                                    }
                                });

                                $(this).prop('disabled', false);

                                if ($(this).parents('tr').find('.make-free-input').is(':checked')) {
                                    $(this).val(0);
                                    m_price = 0;
                                } else { if (parseInt($(this).val()) < 5 || parseInt($(this).val()) > 99) {
                                        $(this).val(5);
                                        m_price = 5;
                                        showNotification('alert-warning', 'Price must between the range of $5 - $99', 'top', 'right', 'animated fadeInDown', 'animated fadeOutUp');
                                    }
                                }
                            } else {
                                if ($(this).parents('tr').find('.make-free-input').is(':checked')) {
                                    $(this).val(0);
                                    m_price = 0;
                                } else {
                                    $(this).val(5);
                                    m_price = 5;
                                }
                            }
                        });

                        // MULTI PRICE TEXTBOX ON KEYPRESS EVENT
                        $('.multi-price-input').keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });

                        // SINGLE TEXTBOX ON KEYPRESS EVENT
                        $('.single-price-input').keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });

                        // SINGLE TEXTBOX ON KEYUP EVENT
                        $('.single-price-input').keyup(function() {
                            if ($(this).parents('table').find('.make-free-input').is(':checked')) {
                                $(this).val(0);
                            }
                        });

                        // SINGLE PRICE TEXTBOX ON BLUR EVENT
                        $('.single-price-input').blur(function() {
                            if ($(this).val() != '' && $(this).val() != null) {
                                if ($(this).parents('table').find('.make-free-input').is(':checked')) {
                                    $(this).val(0);
                                    s_price = 0;
                                } else {
                                    if (parseInt($(this).val()) < 5 || parseInt($(this).val()) > 99) {
                                        $(this).val(5);
                                        s_price = 5;
                                        showNotification('alert-warning', 'Price must between the range of $5 - $99', 'top', 'right', 'animated fadeInDown', 'animated fadeOutUp');
                                    }
                                }
                            } else {
                                if ($(this).parents('table').find('.make-free-input').is(':checked')) {
                                    $(this).val(0);
                                    s_price = 0;
                                } else {
                                    $(this).val(5);
                                    s_price = 5;
                                }
                            }
                        });

                        // MAKE SOLO CHECKBOX CHANGE EVENT
                        $('.make-solo-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).is(':checked')) {
                                $(e.target).parents('tr').find('.multi-price').addClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').removeClass('showed');
                                $(e.target).parents('table').find('.single-price').removeClass('display-none');
                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');

                                if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null)
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                    else
                                    {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }
                                else
                                {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null) {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    } else {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    }
                                }

                                $('.start-multi-input').each(function() {
                                    if ($(this).parents('tr').find('.multi-price-input').hasClass('showed') && $(this).is(':checked') && !$(this).parents('tr').find('.make-solo-input').is(':checked')) {
                                        $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                    }
                                });
                            } else {
                                $(e.target).parents('tr').find('.multi-price').removeClass('display-none');
                                $(e.target).parents('tr').find('.multi-price-input').addClass('showed');
                                $(e.target).parents('table').find('.single-price').addClass('display-none');

                                $('.start-multi-input').each(function() {
                                    if ($(this).parents('tr').find('.multi-price-input').hasClass('showed') && !$(this).parents('tr').find('.make-solo-input').is(':checked')) {
                                        $(this).parents('tr').find('.multi-price-input').prop('disabled', false);
                                    }
                                });

                                if ($(e.target).parents('tr').find('.start-multi-input').is(':checked')) {
                                    if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                        if ($(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() != null) {
                                            if (typeof multi_count != 'NaN' && multi_count >= 1) {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                            } else {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            }
                                        } else {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        }
                                    } else {
                                        if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() != null && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != '' && $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val() != null) {
                                            if (typeof multi_count != 'NaN' && multi_count >= 1) {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                            } else {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            }
                                        } else {
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        }
                                    }
                                }
                            }
                        });

                        // FREE CHECKBOX CHANGE EVENT
                        $('.make-free-input').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            var table_id = $(e.target).parents('table').attr('id');
                            if ($(e.target).is(':checked')) {
                                $(e.target).parents('table').find('.single-price-input').val(0);
                                $(e.target).parents('table').find('.multi-price-input').val(0);
                                $(e.target).parents('table').find('.teaser').addClass('display-none');
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                $('.multi-price-input').prop('disabled', false);

                                if (typeof multi_count != 'NaN' && multi_count >= 1) {
                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                } else {
                                    if ($(e.target).parents('tr').find('.start-multi-input').is(':checked')) {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                    } else {
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                        $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                    }
                                }

                                $(e.target).parents('table').find('.rating-type-select').html('<option value="FREE">FREE</option>');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').prop('disabled', true);
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val('');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').prop('disabled', true);
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val('');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay').addClass('display-none');
                                $(e.target).parents('table').find('tr.active-row').find('.tplay-title').addClass('display-none');
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('getRatingNumber') }}",
                                    type: 'POST',
                                    data: {rating_type: 'FREE'},
                                    success: function(success) {
                                        var jsonData = JSON.parse(success);
                                        if (jsonData.status_code == 200) {
                                            var rating_number_option = '';
                                            for(var i=0; i<jsonData.result.length; i++) {
                                                rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                            }

                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                        } else {
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                        }
                                    }
                                });
                            } else {
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                $(e.target).parents('table').find('.single-price-input').val(s_price);
                                $(e.target).parents('table').find('.multi-price-input').val(m_price);
                                // $('.multi-price-input').prop('disabled', true);
                                $(e.target).parents('tr').find('.multi-price-input').prop('disabled', false);
                                $(e.target).parents('table').find('.btn_save').addClass('display-none');
                                $(e.target).parents('table').find('.btn_continue').addClass('display-none');
                                $(e.target).parents('table').find('.publish-details').addClass('display-none');

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('getRatingType') }}",
                                    type: 'POST',
                                    success: function(success) {
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');

                                        $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                        $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                    }
                                });
                            }
                        });

                        // SELECTED DETAILS CLICK EVENT
                        $(document).on('click', '.selected-details', function(e) {
                            $(e.target).parents('table').find('.start-multi-input').prop('disabled', true);
                            if (('integrity_list' in sessionStorage)) {
                                var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                var list_array = Object.values(list);

                                if (list_array.indexOf($(e.target).parents('td').data('integrityid')) === -1) {
                                    table_id = $(e.target).parents('table').attr('id');
                                    $(e.target).parents('table').find('.active-details').removeClass('active-details');
                                    $(e.target).parents('table').find('.active-row').removeClass('active-row');
                                    $(e.target).parents('td').addClass('active-details');
                                    $(e.target).parents('tr').next('tr').addClass('active-row');
                                    $(e.target).parents('tr').next('tr').find('.selected-header').text($(e.target).data('head'));
                                    $(e.target).parents('tr').next('tr').find('.selected-header-input').val($(e.target).data('head'));
                                    $(e.target).parents('tr').next('tr').find('.selected-juice-input').val($(e.target).data('juice'));
                                    $(e.target).parents('tr').next('tr').find('.selected-value').text($(e.target).data('value'));
                                    $(e.target).parents('tr').next('tr').find('.selected-value-input').val($(e.target).data('value'));
                                    $(e.target).parents('tr').next('tr').find('.selected-integrity-id').val($(e.target).parents('td').data('integrityid'));
                                    $(e.target).parents('tr').next('tr').removeClass('display-none');
                                    $(e.target).parents('table').find('.game-info').addClass('display-none');

                                    if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{ route('getRatingNumber') }}",
                                            type: 'POST',
                                            data: {rating_type: 'FREE'},
                                            success: function(success) {
                                                var jsonData = JSON.parse(success);
                                                if (jsonData.status_code == 200) {
                                                    var rating_number_option = '';
                                                    for(var i=0; i<jsonData.result.length; i++) {
                                                        rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                                    }

                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                                } else {
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                    $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                                }

                                                if (($(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || (!$(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || ($(e.target).parents('table').find('.make-solo-input').is(':checked') && $(e.target).parents('table').find('.start-multi-input').is(':checked'))) {
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                                } else {
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                                    $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                                }
                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "{{ route('getRatingType') }}",
                                            type: 'POST',
                                            success: function(success) {
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                            }
                                        });
                                    }

                                    if ($(e.target).parents('tbody').find('.publish-details').length == 0) {
                                        $(e.target).parents('tbody').append(publish_details);
                                        $(e.target).parents('table').find('.pick-title-input').attr('id', 'pick_title_'+table_id);
                                        $(e.target).parents('table').find('.pick-teaser-input').attr('id', 'pick_teaser_'+table_id);
                                        $(e.target).parents('table').find('.pick-analysis-input').attr('id', 'pick_anaylysis_'+table_id);
                                    }

                                    tinymce.init({
                                        selector: 'textarea',
                                        // placeholder: "Please enter teaser here...",
                                        height: "300",
                                        width: "auto",
                                        themes: "modern",
                                        menubar: true,
                                        menu: {
                                            file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                                            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                                            view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                                            insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                                            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                                            tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                                            table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                                            help: { title: 'Help', items: 'help' }
                                        },
                                        plugins: [
                                            'advlist autolink lists link image charmap print preview anchor textcolor',
                                            'searchreplace visualblocks code fullscreen',
                                            'insertdatetime media table contextmenu paste code help wordcount image imagetools'
                                        ],
                                        toolbar: 'media link image table | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                    });
                                } else {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Integrity Validation');
                                    $('#p_body').html('Element integrity has been violated! Unable to continue this action.');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            } else {
                                table_id = $(e.target).parents('table').attr('id');
                                $(e.target).parents('table').find('.active-details').removeClass('active-details');
                                $(e.target).parents('table').find('.active-row').removeClass('active-row');
                                $(e.target).parents('td').addClass('active-details');
                                $(e.target).parents('tr').next('tr').addClass('active-row');
                                $(e.target).parents('tr').next('tr').find('.selected-header').text($(e.target).data('head'));
                                $(e.target).parents('tr').next('tr').find('.selected-header-input').val($(e.target).data('head'));
                                $(e.target).parents('tr').next('tr').find('.selected-juice-input').val($(e.target).data('juice'));
                                $(e.target).parents('tr').next('tr').find('.selected-value').text($(e.target).data('value'));
                                $(e.target).parents('tr').next('tr').find('.selected-value-input').val($(e.target).data('value'));
                                $(e.target).parents('tr').next('tr').find('.selected-integrity-id').val($(e.target).parents('td').data('integrityid'));
                                $(e.target).parents('tr').next('tr').removeClass('display-none');
                                $(e.target).parents('table').find('.game-info').addClass('display-none');

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route('getRatingNumber') }}",
                                        type: 'POST',
                                        data: {rating_type: 'FREE'},
                                        success: function(success) {
                                            var jsonData = JSON.parse(success);
                                            if (jsonData.status_code == 200) {
                                                var rating_number_option = '';
                                                for(var i=0; i<jsonData.result.length; i++) {
                                                    rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                                }

                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', false);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html(rating_number_option);
                                            } else {
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                                $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                            }

                                            if (($(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || (!$(e.target).parents('table').find('.make-solo-input').is(':checked') && !$(e.target).parents('table').find('.start-multi-input').is(':checked')) || ($(e.target).parents('table').find('.make-solo-input').is(':checked') && $(e.target).parents('table').find('.start-multi-input').is(':checked'))) {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').removeClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').addClass('display-none');
                                            } else {
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_save').addClass('display-none');
                                                $(e.target).parents('table').find('tr.active-row').find('.btn_continue').removeClass('display-none');
                                            }
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ route('getRatingType') }}",
                                        type: 'POST',
                                        success: function(success) {
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').html(success);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val('');
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').prop('disabled', true);
                                            $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').html('');
                                        }
                                    });
                                }

                                if ($(e.target).parents('tbody').find('.publish-details').length == 0) {
                                    $(e.target).parents('tbody').append(publish_details);
                                    $(e.target).parents('table').find('.pick-title-input').attr('id', 'pick_title_'+table_id);
                                    $(e.target).parents('table').find('.pick-teaser-input').attr('id', 'pick_teaser_'+table_id);
                                    $(e.target).parents('table').find('.pick-analysis-input').attr('id', 'pick_anaylysis_'+table_id);
                                }

                                tinymce.init({
                                    selector: 'textarea',
                                    // placeholder: "Please enter teaser here...",
                                    height: "300",
                                    width: "auto",
                                    themes: "modern",
                                    menubar: true,
                                    menu: {
                                        file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                                        edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                                        view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                                        insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                                        format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                                        tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                                        table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                                        help: { title: 'Help', items: 'help' }
                                    },
                                    plugins: [
                                    'advlist autolink lists link image charmap print preview anchor textcolor',
                                    'searchreplace visualblocks code fullscreen',
                                    'insertdatetime media table contextmenu paste code help wordcount image imagetools'
                                    ],
                                    toolbar: 'media link image table | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                });
                            }

                            return false;
                        });

                        // BUTTON RESET CLICK EVENT
                        $('.btn_reset_selected_pick').click(function() {
                            $(this).parents('tr').addClass('display-none');
                            $(this).parents('table').find('.game-info').removeClass('display-none');
                            $(this).parents('table').find('.publish-details').addClass('display-none');
                            $(this).parents('table').find('.start-multi-input').prop('disabled', false);
                        });

                        // RATING TYPE SELECT OPTION CHANGE EVENT
                        $('.rating-type-select').change(function(e) {

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{ route('getRatingNumber') }}",
                                // url: 'get_rating_number',
                                type: 'POST',
                                data: {rating_type: $(e.target).val()},
                                success: function(success) {
                                    var jsonData = JSON.parse(success);

                                    if (jsonData.status_code == 200)
                                    {
                                        var rating_number_option = '';
                                        for(var i=0; i<jsonData.result.length; i++)
                                        {
                                            rating_number_option += '<option value="'+jsonData.result[i]+'">'+jsonData.result[i]+'</option>';
                                        }

                                        $(e.target).parents('tr').find('.rating-number-select').prop('disabled', false);
                                        $(e.target).parents('tr').find('.rating-number-select').html(rating_number_option);

                                        var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                                        if ($(e.target).val() == 'TOPPLAY')
                                        {
                                            $(e.target).parents('tr').find('.tplay-designation-select').prop('disabled', false);
                                            $(e.target).parents('tr').find('.tplay').removeClass('display-none');
                                            $(e.target).parents('tr').find('.tplay-title-select').prop('disabled', false);
                                            $(e.target).parents('tr').find('.tplay-title').removeClass('display-none');
                                            $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                            $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                            $(e.target).parents('table').find('.publish-details').addClass('display-none');
                                        }
                                        else
                                        {
                                            $(e.target).parents('tr').find('.tplay-designation-select').prop('disabled', true);
                                            $(e.target).parents('tr').find('.tplay-designation-select').val('');
                                            $(e.target).parents('tr').find('.tplay-title-select').prop('disabled', true);
                                            $(e.target).parents('tr').find('.tplay-title-select').val('');

                                            $(e.target).parents('tr').find('.tplay').addClass('display-none');
                                            $(e.target).parents('tr').find('.tplay-title').addClass('display-none');

                                            if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked'))
                                            {
                                                $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                                $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                            }
                                            else
                                            {
                                                if (typeof multi_count != 'NaN' && multi_count >= 1)
                                                {
                                                    $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                                    $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                                }
                                                else
                                                {
                                                    $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                                    $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $(e.target).parents('tr').find('.rating-number-select').prop('disabled', true);
                                        $(e.target).parents('tr').find('.rating-number-select').html('');
                                    }
                                }
                            });
                        });

                        // BUTTON SAVE CLICK EVENT
                        $('.btn_save').click(function(e) {
                            // var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-details').length > 0)
                            {
                                if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == null)
                                {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign pitcher first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                if ($(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == null || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == null) {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign T-Play designation and T-Play title first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            $(e.target).parents('table').find('.publish-details').removeClass('display-none');
                            $(e.target).parents('table').find('.title').removeClass('display-none');

                            if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                $(e.target).parents('table').find('.teaser').addClass('display-none');
                            } else {
                                $(e.target).parents('table').find('.teaser').removeClass('display-none');
                            }

                            $(e.target).parents('table').find('.analysis').removeClass('display-none');

                            $(e.target).parents('table').find('.btn-publish').removeClass('display-none');
                            $(e.target).parents('table').find('.btn-continue-multi').addClass('display-none');
                            $(e.target).parents('table').find('.pick-title-input').prop('disabled', false);
                            tinymce.get('pick_teaser_'+table_id).mode.set("design");
                        });

                        // TPLAY TITLE CHANGE EVENT
                        $('.tplay-title-select').change(function(e) {
                            var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                            if ($(e.target).val() != '') {
                                if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked')) {
                                    $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                    $(e.target).parents('tr').find('.btn_continue').addClass('display-none');
                                } else {
                                    if (typeof multi_count != 'NaN' && multi_count >= 1) {
                                        $(e.target).parents('tr').find('.btn_save').removeClass('display-none');
                                        $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                    } else {
                                        $(e.target).parents('tr').find('.btn_save').addClass('display-none');
                                        $(e.target).parents('tr').find('.btn_continue').removeClass('display-none');
                                    }
                                }
                            }
                        });

                        // Publish Details Validation
                        $('table').on('click', '.btn-publish', function(e) {
                            if ($(e.target).parents('table').find('.make-solo-input').is(':checked') || !$(e.target).parents('table').find('.start-multi-input').is(':checked')) {
                                var pick_title      = $(e.target).parents('tr').find('.pick-title-input').val();
                                var pick_teaser     = tinymce.get('pick_teaser_'+table_id).getContent();
                                var pick_anaylysis  = tinymce.get('pick_anaylysis_'+table_id).getContent();

                                var sport_id        = $(e.target).parents('table').data('sportid');
                                var league_id       = $(e.target).parents('table').data('leagueid');
                                var price           = $(e.target).parents('table').find('tr.active-row').find('.single-price-input').val();

                                var event_id        = $(e.target).parents('table').attr('id');
                                var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();
                                if (parseInt(sport_id) == 3 && parseInt(league_id) == 5) {
                                    var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                } else {
                                    var pitcher     = '';
                                }

                                if (rating_type == 'TOPPLAY') {
                                    var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                    var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                } else {
                                    var tplay_designation   = '';
                                    var tplay_title         = '';
                                }

                                var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                var picksData = [{
                                    pick_title: pick_title,
                                    pick_teaser: pick_teaser,
                                    pick_anaylysis: pick_anaylysis,
                                    sport_id: sport_id,
                                    league_id: league_id,
                                    price: price,
                                    event_id: event_id,
                                    rating_type: rating_type,
                                    rating_number: rating_number,
                                    pitcher: pitcher,
                                    tplay_designation: tplay_designation,
                                    tplay_title: tplay_title,
                                    selected_element: selected_element,
                                    selected_juice: selected_juice,
                                    element_value: element_value,
                                    rot_id: rot_id,
                                    side: side,
                                    team_name: team_name,
                                    event_datetime: event_datetime,
                                    ticket_type: 1,
                                }];

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                    if (pick_title == '' || pick_title == null || pick_anaylysis == '' || pick_anaylysis == null) {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('Please fill all needed information!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                } else {
                                    if (pick_title == '' || pick_title == null || pick_teaser == '' || pick_teaser == null || pick_anaylysis == '' || pick_anaylysis == null) {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('Please fill all needed information!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                }

                                if (('integrity_list' in sessionStorage)) {
                                    var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                    var list_array = Object.values(list);

                                    list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                    sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                } else {
                                    sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                }

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('saveNewPick') }}",
                                    type: 'POST',
                                    data: {picks_data: picksData, group_key: getRandomString(6)},
                                    success: function(success) {
                                        var jsonData = JSON.parse(success);
                                        if (jsonData.status_code == 200) {
                                            $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                            $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                            $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                            $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                            $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');
                                            $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                            $(e.target).parents('tr').find('.pick-title-input').val('');
                                            tinymce.get('pick_teaser_'+table_id).setContent('');
                                            tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                            if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                                $(e.target).parents('table').find('.multi-price-input').val(0);
                                                $(e.target).parents('table').find('.single-price-input').val(0);
                                            } else {
                                                $(e.target).parents('table').find('.multi-price-input').val(5);
                                                $(e.target).parents('table').find('.single-price-input').val(5);
                                            }

                                            $(e.target).parents('table').find('.rating-type-select').val('');
                                            $(e.target).parents('table').find('.rating-number-select').html('');
                                            $(e.target).parents('table').find('.pitcher-select').val('');
                                            $(e.target).parents('table').find('.tplay-designation-select').val('');
                                            $(e.target).parents('table').find('.tplay-title-select').val('');

                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Success');
                                            $('#p_body').html(jsonData.status_message);
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });
                                        } else {
                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Error');
                                            $('#p_body').html('Internal Server Error');
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });
                                        }
                                    },
                                    error: function(error) {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Error');
                                        $('#p_body').html('Internal Server Error');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });
                                    }
                                });
                            } else {
                                if (('multi_picks_data' in sessionStorage)) {
                                    var multi_picks_data_list = JSON.parse(sessionStorage.getItem('multi_picks_data'));
                                    var multi_picks_data = Object.values(multi_picks_data_list);

                                    if (multi_picks_data.length > 0) {
                                        var tbl_id          = $(e.target).parents('table').attr('id');
                                        var pick_title      = $(e.target).parents('table').find('.pick-title-input').val();
                                        var pick_teaser     = tinymce.get('pick_teaser_'+tbl_id).getContent();
                                        var pick_anaylysis  = tinymce.get('pick_anaylysis_'+tbl_id).getContent();

                                        var sport_id        = $(e.target).parents('table').data('sportid');
                                        var league_id       = $(e.target).parents('table').data('leagueid');

                                        var price           = $(e.target).parents('table').find('.multi-price-input').val();

                                        var event_id        = $(e.target).parents('table').attr('id');
                                        var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                        var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();
                                        if (parseInt(sport_id) == 3 && parseInt(league_id) == 5) {
                                            var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                        } else {
                                            var pitcher     = '';
                                        }

                                        if (rating_type == 'TOPPLAY') {
                                            var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                            var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                        } else {
                                            var tplay_designation   = '';
                                            var tplay_title         = '';
                                        }

                                        var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                        var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                        var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                        var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                        var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                        var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                        var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                        if (pick_title == '' || pick_title == null || pick_teaser == ''|| pick_teaser == null || pick_anaylysis == '' || pick_anaylysis == null) {
                                            $('.waiting-overlay').hide();
                                            $('#btn_modal_close').show();
                                            $('#btn_modal_ok').hide();
                                            $('#alertModalTitle').html('Publish Details Validation');
                                            $('#p_body').html('Please fill all needed information!');
                                            $('#alertModal').modal({
                                                keyboard: false,
                                                backdrop: 'static',
                                                show: true
                                            });

                                            return false;
                                        } else {
                                            var picksData = {
                                                pick_title: pick_title,
                                                pick_teaser: pick_teaser,
                                                pick_anaylysis: pick_anaylysis,
                                                sport_id: sport_id,
                                                league_id: league_id,
                                                price: price,
                                                event_id: event_id,
                                                rating_type: rating_type,
                                                rating_number: rating_number,
                                                pitcher: pitcher,
                                                tplay_designation: tplay_designation,
                                                tplay_title: tplay_title,
                                                selected_element: selected_element,
                                                selected_juice: selected_juice,
                                                element_value: element_value,
                                                rot_id: rot_id,
                                                side: side,
                                                team_name: team_name,
                                                event_datetime: event_datetime,
                                                ticket_type: 2
                                            };

                                            multi_picks_data.push(picksData);
                                            sessionStorage.setItem('multi_picks_data', JSON.stringify(multi_picks_data));

                                            if (('integrity_list' in sessionStorage)) {
                                                var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                                var list_array = Object.values(list);

                                                list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                                sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                            } else {
                                                sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                            }

                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "{{ route('saveNewPick') }}",
                                                type: 'POST',
                                                data: {picks_data: multi_picks_data, group_key: getRandomString(6)},
                                                success: function(success) {
                                                    var jsonData = JSON.parse(success);
                                                    if (jsonData.status_code == 200) {
                                                        $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                                        $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                                        $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                                        $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                                        $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');

                                                        $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                                        $(e.target).parents('tr').find('.pick-title-input').val('');
                                                        tinymce.get('pick_teaser_'+table_id).setContent('');
                                                        tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                                        if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                                            $(e.target).parents('table').find('.multi-price-input').val(0);
                                                            $(e.target).parents('table').find('.single-price-input').val(0);
                                                        } else {
                                                            $(e.target).parents('table').find('.multi-price-input').val(5);
                                                            $(e.target).parents('table').find('.single-price-input').val(5);
                                                        }

                                                        $(e.target).parents('table').find('.rating-type-select').val('');
                                                        $(e.target).parents('table').find('.rating-number-select').html('');
                                                        $(e.target).parents('table').find('.pitcher-select').val('');
                                                        $(e.target).parents('table').find('.tplay-designation-select').val('');
                                                        $(e.target).parents('table').find('.tplay-title-select').val('');
                                                        sessionStorage.removeItem('multi_picks_data');
                                                        sessionStorage.setItem('multi_count', 0);

                                                        $('.start-multi-input').prop('checked', false);
                                                        $('.make-free-input').prop('checked', false);
                                                        $('.make-solo-input').prop('checked', false);
                                                        $('.multi-price').addClass('display-none');

                                                        $('.waiting-overlay').hide();
                                                        $('#btn_modal_close').show();
                                                        $('#btn_modal_ok').hide();
                                                        $('#alertModalTitle').html('Success');
                                                        $('#p_body').html(jsonData.status_message);
                                                        $('#alertModal').modal({
                                                            keyboard: false,
                                                            backdrop: 'static',
                                                            show: true
                                                        });
                                                    } else {
                                                        $('.waiting-overlay').hide();
                                                        $('#btn_modal_close').show();
                                                        $('#btn_modal_ok').hide();
                                                        $('#alertModalTitle').html('Error');
                                                        $('#p_body').html('Internal Server Error');
                                                        $('#alertModal').modal({
                                                            keyboard: false,
                                                            backdrop: 'static',
                                                            show: true
                                                        });
                                                    }
                                                },
                                                error: function(error) {
                                                    $('.waiting-overlay').hide();
                                                    $('#btn_modal_close').show();
                                                    $('#btn_modal_ok').hide();
                                                    $('#alertModalTitle').html('Error');
                                                    $('#p_body').html('Internal Server Error');
                                                    $('#alertModal').modal({
                                                        keyboard: false,
                                                        backdrop: 'static',
                                                        show: true
                                                    });
                                                }
                                            });
                                        }
                                    } else {
                                        $('.waiting-overlay').hide();
                                        $('#btn_modal_close').show();
                                        $('#btn_modal_ok').hide();
                                        $('#alertModalTitle').html('Publish Details Validation');
                                        $('#p_body').html('No picks data found!');
                                        $('#alertModal').modal({
                                            keyboard: false,
                                            backdrop: 'static',
                                            show: true
                                        });

                                        return false;
                                    }
                                } else {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Publish Details Validation');
                                    $('#p_body').html('No picks data found!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }
                        });

                        $('.btn_continue').click(function(e) {
                            $(e.target).parents('table').find('.btn-publish').addClass('display-none');
                            $(e.target).parents('table').find('.btn-continue-multi').removeClass('display-none');

                            if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-details').length > 0) {
                                if ($(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val() == null) {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign pitcher first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            if ($(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val() == 'TOPPLAY') {
                                if ($(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val() == null || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == '' || $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val() == null) {
                                    $('.waiting-overlay').hide();
                                    $('#btn_modal_close').show();
                                    $('#btn_modal_ok').hide();
                                    $('#alertModalTitle').html('Input Validation');
                                    $('#p_body').html('Please assign T-Play designation and T-Play title first!');
                                    $('#alertModal').modal({
                                        keyboard: false,
                                        backdrop: 'static',
                                        show: true
                                    });

                                    return false;
                                }
                            }

                            $(e.target).parents('table').find('.analysis').removeClass('display-none');
                            $(e.target).parents('table').find('.publish-details').removeClass('display-none');
                            $(e.target).parents('table').find('.title').removeClass('display-none');
                            $(e.target).parents('table').find('.teaser').removeClass('display-none');
                            $(e.target).parents('table').find('.pick-title-input').prop('disabled', true);
                            tinymce.get('pick_teaser_'+table_id).mode.set("readonly");
                        });

                        // Continue Multi Button Click Event
                        $('table').on('click', '.btn-continue-multi', function(e) {
                            if (tinymce.get('pick_anaylysis_'+table_id).getContent() != '' && tinymce.get('pick_anaylysis_'+table_id).getContent() != null) {
                                if (('integrity_list' in sessionStorage)) {
                                    var list = JSON.parse(sessionStorage.getItem('integrity_list'));
                                    var list_array = Object.values(list);

                                    list_array.push($(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val());
                                    sessionStorage.setItem('integrity_list', JSON.stringify(list_array));
                                } else {
                                    sessionStorage.setItem('integrity_list', JSON.stringify([$(e.target).parents('table').find('tr.active-row').find('.selected-integrity-id').val()]));
                                }

                                var tbl_id          = $(e.target).parents('table').attr('id');
                                var pick_title      = $(e.target).parents('table').find('.pick-title-input').val();
                                var pick_teaser     = tinymce.get('pick_teaser_'+tbl_id).getContent();
                                var pick_anaylysis  = tinymce.get('pick_anaylysis_'+tbl_id).getContent();
                                var sport_id        = $(e.target).parents('table').data('sportid');
                                var league_id       = $(e.target).parents('table').data('leagueid');
                                var price           = $(e.target).parents('table').find('.multi-price-input').val();
                                var event_id        = $(e.target).parents('table').attr('id');
                                var rating_type     = $(e.target).parents('table').find('tr.active-row').find('.rating-type-select').val();
                                var rating_number   = $(e.target).parents('table').find('tr.active-row').find('.rating-number-select').val();

                                if (parseInt(sport_id) == 3 && parseInt(league_id) == 5) {
                                    var pitcher     = $(e.target).parents('table').find('tr.active-row').find('.pitcher-select').val();
                                } else {
                                    var pitcher     = '';
                                }

                                if (rating_type == 'TOPPLAY') {
                                    var tplay_designation   = $(e.target).parents('table').find('tr.active-row').find('.tplay-designation-select').val();
                                    var tplay_title         = $(e.target).parents('table').find('tr.active-row').find('.tplay-title-select').val();
                                } else {
                                    var tplay_designation   = '';
                                    var tplay_title         = '';
                                }

                                var selected_element    = $(e.target).parents('table').find('tr.active-row').find('.selected-header-input').val();
                                var selected_juice      = $(e.target).parents('table').find('tr.active-row').find('.selected-juice-input').val();
                                var element_value       = $(e.target).parents('table').find('tr.active-row').find('.selected-value-input').val();
                                var rot_id              = $(e.target).parents('table').find('tr.active-row').find('.rot-input').val();
                                var side                = $(e.target).parents('table').find('tr.active-row').find('.side-input').val();
                                var team_name           = $(e.target).parents('table').find('tr.active-row').find('.team-name-input').val();
                                var event_datetime      = $(e.target).parents('table').find('tr.active-row').find('.event-datetime-input').val();

                                var picksData = {
                                    pick_title: pick_title,
                                    pick_teaser: pick_teaser,
                                    pick_anaylysis: pick_anaylysis,
                                    sport_id: sport_id,
                                    league_id: league_id,
                                    price: price,
                                    event_id: event_id,
                                    rating_type: rating_type,
                                    rating_number: rating_number,
                                    pitcher: pitcher,
                                    tplay_designation: tplay_designation,
                                    tplay_title: tplay_title,
                                    selected_element: selected_element,
                                    selected_juice: selected_juice,
                                    element_value: element_value,
                                    rot_id: rot_id,
                                    side: side,
                                    team_name: team_name,
                                    event_datetime: event_datetime,
                                    ticket_type: 2
                                };

                                if (('multi_picks_data' in sessionStorage)) {
                                    var multi_picks_data_list = JSON.parse(sessionStorage.getItem('multi_picks_data'));
                                    var multi_picks_data = Object.values(multi_picks_data_list);
                                    multi_picks_data.push(picksData);
                                    sessionStorage.setItem('multi_picks_data', JSON.stringify(multi_picks_data));
                                } else {
                                    sessionStorage.setItem('multi_picks_data', JSON.stringify([picksData]));
                                }

                                var multi_count = parseInt(sessionStorage.getItem('multi_count'));
                                if (typeof multi_count != 'NaN') {
                                    multi_count+=1;
                                } else {
                                    multi_count=1;
                                }

                                sessionStorage.setItem('multi_count', multi_count);

                                $(e.target).parents('table').find('.active-details').find('.odds-hover').removeClass('odds-hover');
                                $(e.target).parents('table').find('.active-details').find('.selected-details').removeClass('selected-details');
                                $(e.target).parents('table').find('.active-details').find('.text-dark').removeClass('text-dark');
                                $(e.target).parents('table').find('.active-details').find('div').addClass('text-red');
                                $(e.target).parents('table').find('.active-details').find('span').addClass('text-red');

                                $(e.target).parents('table').find('.btn_reset_selected_pick').trigger('click');
                                $(e.target).parents('tr').find('.pick-title-input').val('');
                                tinymce.get('pick_teaser_'+table_id).setContent('');
                                tinymce.get('pick_anaylysis_'+table_id).setContent('');

                                if ($(e.target).parents('table').find('.make-free-input').is(':checked')) {
                                    $(e.target).parents('table').find('.multi-price-input').val(0);
                                    $(e.target).parents('table').find('.single-price-input').val(0);
                                } else {
                                    $(e.target).parents('table').find('.multi-price-input').val(5);
                                    $(e.target).parents('table').find('.single-price-input').val(5);
                                }

                                $(e.target).parents('table').find('.rating-type-select').val('');
                                $(e.target).parents('table').find('.rating-number-select').html('');
                                $(e.target).parents('table').find('.pitcher-select').val('');
                                $(e.target).parents('table').find('.tplay-designation-select').val('');
                                $(e.target).parents('table').find('.tplay-title-select').val('');
                            } else {
                                $('.waiting-overlay').hide();
                                $('#btn_modal_close').show();
                                $('#btn_modal_ok').hide();
                                $('#alertModalTitle').html('Invalid Input');
                                $('#p_body').html('Please enter analysis info first!');
                                $('#alertModal').modal({
                                    keyboard: false,
                                    backdrop: 'static',
                                    show: true
                                });
                            }
                        });
                    },
                    error: function() {
                        $('.waiting-overlay').hide();
                        $('#btn_modal_close').show();
                        $('#btn_modal_ok').hide();
                        $('#alertModalTitle').html('Error');
                        $('#p_body').html('An error occurred during action request!');
                        $('#alertModal').modal({
                            keyboard: false,
                            backdrop: 'static',
                            show: true
                        });
                    }
                });
            });
        });

        $('#btn_modal_ok').click(function() {
            window.location.reload();
        });

        function getRandomString(length) {
			var result = '';
			var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			var charactersLength = characters.length;
			for ( var i = 0; i < length; i++ ) {
				result += characters.charAt(Math.floor(Math.random() * charactersLength));
			}

			return result;
		}
    </script>
@endsection
