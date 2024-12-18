@csrf




<!--begin::Input group --  Area Name -->
<div class="row mb-6">

    <!--begin::Input group-->
    <div class="col-lg-12 fv-row">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('Name') }}</label>
        <!--end::Label-->
        <div class="input-group lang_container" id="lang_container_name">
           
            <input
            type="text"
            placeholder="{{ __('name') }}"
            name="name"
            required
            title=""
            class="form-control section-title form-control-multilingual form-control @error('name') is-invalid @enderror  "
            value="{{ isset($model) && isset($model->name ) ? $model->name : '' }}"
        >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <!--end::Input group-->
    <div class="col-lg-12 fv-row">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('Description') }}</label>
        <!--end::Label-->
        <div class="input-group lang_container" id="lang_container_desc">
            <textarea
                placeholder="{{ __('description') }}"
                name="desc"
                required
                title=""
                class="form-control section-title form-control-multilingual form-control @error('desc') is-invalid @enderror"
                rows="4"
            >{{ isset($model) && isset($model->desc) ? $model->desc : '' }}</textarea>
            @error('desc')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
</div>
<!--end::Input group-->


{{-- Inject Scripts --}}
@push('js-component')

@endpush

