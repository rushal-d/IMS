<footer class="app-footer">
    <div>
        <a href="/">Investment Management System</a>
        <span>&copy; <?php echo date('Y') ?> BMPInfology.</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="https://bmpinfology.com">BMP Infology</a>
    </div>
</footer>
<!-- Bootstrap and necessary plugins-->
<script src="{{asset('assets/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('js/flatpickr.js')}}"></script>
<script src="{{asset('assets/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/pace-progress/pace.min.js')}}"></script>
<script src="{{asset('assets/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/@coreui/coreui/dist/js/coreui.min.js')}}"></script>
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"
        integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy"
        crossorigin="anonymous"></script>

{{--<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"--}}
{{--integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>--}}
{{--Nepali Date pciker--}}
<script src="{{ asset('js/nepali.datepicker.v2.2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
{{--for frontend validation--}}
{{--for selectize--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.fancybox.min.js"></script>
<script src="{{ asset('assets') }}/js/vex.combined.min.js"></script>
<script>
    $.validate({
        lang: 'en',
        modules: 'date',
        validateHiddenInputs: true,
        scrollToTopOnError: true
    });
    //disable form submit on enter
    $(document).ready(function() {
        $(window).keydown(function(event){
            if((event.keyCode == 13) && ($(event.target)[0]!=$("textarea")[0])) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
<!-- Plugins and scripts required by this view-->
<script src="{{asset('js/customjavascript.js')}}"></script>
{{--<script src="{{asset('js/menuorder.js')}}"></script>--}}

<script src="{{ asset('assets/js/freeze-table.js') }}"></script>
<script src="{{ asset('assets/js/scrollbooster.min.js') }}"></script>
<script src="{{ asset('js/selectize/dist/js/standalone/selectize.js') }}"></script>
<script>
    //freeze header, it can also freeze multiple column
    $(".freezeHeaderTableContainer").freezeTable({
        'shadow': true,
        'freezeColumn': false,
    });
    //now it enables draggable inside content and the button are also clickable
    const viewport = document.querySelector('.freezeHeaderTableContainer')
    content = document.querySelector('.freezeHeaderTable')
    let sb = new ScrollBooster({
        viewport: viewport, // required
        content: content,
        mode: 'x',
        onUpdate: (data)=> {
            viewport.scrollLeft = data.position.x
        }
    });

    $.formUtils.addValidator({
        name: 'within_2months',
        validatorFunction: function (value, $el, config, language, $form) {
            var inputDate = new Date(value);
            var twoMonthDate = new Date('{{date('Y-m-d',strtotime('+2 months'))}}');
            if ((inputDate > twoMonthDate)) {
                return false;
            }
            return true;

        },
        errorMessage: 'Date is greater than 2 Month from Current Date',
        errorMessageKey: 'badEvenNumber'
    });
</script>
@yield('scripts')
