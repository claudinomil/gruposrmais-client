<!-- libs -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/bootstrap/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-validation/jquery-validation.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-validation/jquery-validation-pt-br.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/jquery-validation-methods.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/libs/jquery-mask/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/jquery-masks.js') }}"></script>
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/main.js') }}"></script>

<!-- functions.js -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/functions.js') }}"></script>

<!-- scripts_profiles.js -->
<script type="text/javascript" src="{{ Vite::asset('resources/assets_template/js/scripts_profiles.js') }}"></script>

@yield('script')

@yield('script-bottom')
