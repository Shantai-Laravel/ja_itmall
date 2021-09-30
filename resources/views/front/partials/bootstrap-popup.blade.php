@if (!@$_COOKIE['cookie'])
    <div class="modal" id="bootstrap-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modalHeader">
                    {{-- <span>{{ trans('vars.FormFields.settings') }}</span> --}}
                </div>
                <boostrap-popup></boostrap-popup>
            </div>
        </div>
    </div>
@endif
