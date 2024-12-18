@csrf


<!--begin::Input group -- From Country -->
<div class="row">

    <!--begin::Input group-->
    <div class="col-md-6 fv-row form-group">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('cargo::view.from_region') }}</label>
        <!--end::Label-->
        <select class="form-control  @error('from_state_id') is-invalid @enderror" id="change-from-state"
            name="from_state_id" data-control="select2" required
            data-placeholder="{{ __('cargo::view.choose_region') }}" data-allow-clear="true">
            <option></option>
            @foreach ($states as $state)
                <option value="{{ $state->id }}" 
                    {{ !empty($model) && $model->from_state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
            @endforeach
        </select>
        @error('from_state_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 fv-row form-group">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('cargo::view.to_region') }}</label>
        <!--end::Label-->
        <select class="form-control  @error('to_state_id') is-invalid @enderror" name="to_state_id" id="change-to-state"
            required data-control="select2" data-placeholder="{{ __('cargo::view.choose_region') }}"
            data-allow-clear="true">
            <option></option>
            @foreach ($states as $state)
                <option value="{{ $state->id }}" 
                    {{ !empty($model) && $model->to_state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
            @endforeach
        </select>
        @error('to_state_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <!--end::Input group-->
</div>

<div class="row">

    <!--begin::Input group-->
    <div class="col-md-6 fv-row form-group">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('cargo::view.from_area') }}</label>
        <!--end::Label-->
        <select class="form-control  @error('from_state_id') is-invalid @enderror" id="change-from-state"
            name="from_area_id" data-control="select2" required data-placeholder="{{ __('cargo::view.choose_area') }}"
            data-allow-clear="true">
            <option></option>
            @if (!empty($model))

                @foreach ($from_areas as $state)
                    <option value="{{ $state->id }}" {{ old('from_area_id') == $state->id ? 'selected' : '' }}
                        {{ !empty($model) && $model->from_area_id == $state->id ? 'selected' : '' }}>{{  json_decode(  $state->name, true)[app()->getLocale()] }}</option>
                @endforeach

            @endif

        </select>
        @error('from_area_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 fv-row form-group">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('cargo::view.to_area') }}</label>
        <!--end::Label-->
        <select class="form-control  @error('to_area_id') is-invalid @enderror" name="to_area_id" id="change-to-state"
            required data-control="select2" data-placeholder="{{ __('cargo::view.choose_area') }}"
            data-allow-clear="true">
            <option></option>
            @if (!empty($model))

                @foreach ($to_areas as $state)
                    <option value="{{ $state->id }}" {{ old('to_area_id') == $state->id ? 'selected' : '' }}
                        {{  !empty($model) && $model->to_area_id == $state->id ? 'selected' : '' }}>{{  json_decode(  $state->name, true)[app()->getLocale()] }}</option>
                @endforeach
            @endif
        </select>
        @error('to_area_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <!--end::Input group-->
</div>
<!--end::Input group-->

<!--begin::Input group --  Area Name -->
<div class="row mb-6">

    <!--begin::Input group-->
    <div class="col-lg-12 fv-row">
        <!--begin::Label-->
        <label class="col-form-label required fw-bold fs-6">{{ __('Amount') }}</label>
        <!--end::Label-->
        <div class="input-group lang_container" id="lang_container_name">

            <input type="number" name="amount" required
                class="form-control section-title form-control-multilingual form-control @error('amount') is-invalid @enderror"
                value="{{ isset($model) && isset($model->amount) ? $model->amount : '' }}">

            @error('amount')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <!--end::Input group-->
</div>
<!--end::Input group-->


{{-- Inject Scripts --}}
@push('js-component')
    <script>
        // get-states-ajax
        $('#change-from-state').change(function() {
            var id = $(this).val();
            console.log(id);
            $.get("{{ route('ajax.getAreas') }}?state_id=" + id, function(data) {
                console.log(data);
                $('select[name ="from_area_id"]').empty();

                for (let index = 0; index < data.length; index++) {
                    const element = data[index];

                    $('select[name ="from_area_id"]').append('<option value="' + element['id'] + '">' +
                         JSON.parse(element['name'], true)[`{{app()->getLocale()}}`]   + '</option>');

                }
            });
        });

        $('#change-to-state').change(function() {
            var id = $(this).val();
            console.log(id);
            $.get("{{ route('ajax.getAreas') }}?state_id=" + id, function(data) {
                console.log(data);
                $('select[name ="to_area_id"]').empty();

                for (let index = 0; index < data.length; index++) {
                    const element = data[index];

                    $('select[name ="to_area_id"]').append('<option value="' + element['id'] + '">' +
                         JSON.parse(element['name'], true)[`{{app()->getLocale()}}`] + '</option>');

                }
            });
        });
        // end get-states-ajax
        /*******************************************************************************************/
    </script>
@endpush
