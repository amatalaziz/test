@if ($errors->any())
    <div class="alert alert-danger border rounded p-3 mb-4 shadow-sm position-relative" role="alert">
        <h5 class="mb-2 text-danger d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
    
        </h5>
        <ul class="mb-0 ps-4">
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        <!-- تأثير إغلاق التنبيه -->
        <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    /* تأثيرات تفاعلية للإنذار */
  
</style>
