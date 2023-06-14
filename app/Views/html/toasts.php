<style>
    .dangerToasts{
        background: #dc3545;
        color: #fff !important;
    }
    .infoToasts{
        background: #0d6efd;
        color: #fff !important;
    }
    .successToasts{
        background: #198754;
        color: #fff !important;
    }
    .warningToasts{
        background: #ffc107;
        color: #fff !important;
    }
    .toast-header{
        background-color: rgb(255, 255, 255) !important;
    }
</style>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1060">
    <div id="liveToast" class="toast hide dangerToasts" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="<?=base_url()?>/assets/img/logos/logo_small.png" width="15px" class="rounded me-2" alt="...">
            <strong class="me-auto" id="title-toast">Bootstrap</strong>
            <small id="subTitle-toast">11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="body-toast">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>