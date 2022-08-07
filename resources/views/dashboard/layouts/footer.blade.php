<!-- Must needed plugins to the run this Template -->

<script src="/admin/js/popper.min.js"></script>
<script src="/admin/js/bootstrap.min.js"></script>
<script src="/admin/js/bundle.js"></script>
<script src="/admin/js/default-assets/date-time.js"></script>
<script src="/admin/js/default-assets/setting.js"></script>
<script src="/admin/js/default-assets/fullscreen.js"></script>
<script src="/admin/js/default-assets/bootstrap-growl.js"></script>
<script src="/admin/js/default-assets/notification-active.js"></script>

<!-- Active JS -->
<script src="/admin/js/default-assets/active.js"></script>

<script>
    CKEDITOR.replace('editor-id', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    document.addEventListener("DOMContentLoaded", function() {

document.getElementById('button-image').addEventListener('click', (event) => {
  event.preventDefault();

  window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
});
});

// set file link
function fmSetLink($url) {
document.getElementById('image_label').value = $url;
}
</script>

<!-- These plugins only need for the run this page -->
<script src="/admin/js/default-assets/peity.min.js"></script>
<script src="/admin/js/default-assets/peity-demo.js"></script>
<script src="/admin/js/default-assets/am-chart.js"></script>
<script src="/admin/js/default-assets/gauge.js"></script>
<script src="/admin/js/default-assets/serial.js"></script>
<script src="/admin/js/default-assets/light.js"></script>
<script src="/admin/js/default-assets/ammap.min.js"></script>
<script src="/admin/js/default-assets/worldlow.js"></script>
<script src="/admin/js/default-assets/radar.js"></script>
<script src="/admin/js/default-assets/dashboard-2.js"></script>
<script src="{{asset('/admin/js/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/vendor/file-manager/js/file-manager.js')}}"></script>
