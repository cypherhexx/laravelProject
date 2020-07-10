<h6>PayMe</h6>
<hr>
<input type="hidden" name="unique_identifier_id" value="payme">
<div class="form-row">
   <div class="form-group col-md-3">
      <label for="settings[payme_label]" class="control-label">Label <span class="required">*</span></label>
      <input type="text"  name="settings[payme_label]" class="form-control form-control-sm @php if($errors->has('settings.payme_label')) { echo 'is-invalid'; } @endphp" value="" >
      <div class="invalid-feedback">@php if($errors->has('settings.payme_label')) { echo $errors->first('settings.payme_label') ; } @endphp</div>
   </div>

   <div class="form-group col-md-3">
      <label for="settings[payme_password]" class="control-label">PayMe API Key<span class="required">*</span></label>
      <input type="text" id="settings[payme_password]" name="settings[payme_password]" class="form-control form-control-sm @php if($errors->has('settings.payme_password')) { echo 'is-invalid'; } @endphp" value="">
      <div class="invalid-feedback">@php if($errors->has('settings.payme_password')) { echo $errors->first('settings.payme_password') ; } @endphp</div>
   </div>

</div>
<div class="form-group">
   <label for="settings[payme_description_dashboard]" class="control-label">PayMe Description</label>
   <textarea id="settings[payme_description_dashboard]" name="settings[payme_description_dashboard]" class="form-control form-control-sm @php if($errors->has('payme_description_dashboard')) { echo 'is-invalid'; } @endphp" 
      rows="4">
   </textarea>
</div>

<div class="form-group">
   <label for="payme_active" class="control-label clearfix">
   Active </label>
   <div class="radio radio-primary radio-inline">
      <input type="radio" name="settings[payme_active]" value="1" 
      {{ (old_set('payme_active', NULL,$gateway , $old) == 1) ? 'checked' : '' }}
      >
      <label>
     Yes  </label>
   </div>
   <div class="radio radio-primary radio-inline">
      <input type="radio" name="settings[payme_active]" value="0"
      {{ (old_set('payme_active', NULL,$gateway , $old) != 1) ? 'checked' : '' }}
      >
      <label>No </label>
   </div>
</div>
