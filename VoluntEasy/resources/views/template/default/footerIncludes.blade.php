<!-- Javascripts -->
<script src="{{ asset('assets/plugins/jquery/jquery-2.1.3.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.el.js')}}"></script>
<script src="{{ asset('assets/plugins/jonthornton-timepicker/jquery.timepicker.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js')}}"></script>
<script src="{{ asset('assets/plugins/waves/waves.min.js')}}"></script>
<script src="{{ asset('assets/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jOrgChart/jOrgChart.js')}}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.js')}}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/plugins/soundmanager2/soundmanager2-nodebug-jsmin.js')}}"></script>
<script src="{{ asset('assets/plugins/vertical-timeline/js/main.js')}}"></script>
<script src="{{ asset('assets/plugins/raty/lib/jquery.raty.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/extras/tabletools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-2.3.2/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/plugins/fullcalendar-2.3.2/lang-all.js')}}"></script>
<script src="{{ asset('assets/plugins/chartsjs/Chart.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script src="{{ asset('messages.js')}}"></script>
<script src="{{ asset('assets/js/modern.js')}}"></script>
<script src="{{ asset('assets/js/custom.js')}}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js')}}"></script>

@if (\Cookie::get('locale') === 'el')
<script>
    Lang.setLocale('el');
</script>
@else
<script>
    Lang.setLocale('en');
</script>
@endif
