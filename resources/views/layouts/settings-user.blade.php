{{--<!--  Settings -->--}}
{{--<div class="modal fade change-settings-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered modal-xl">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="myLargeModalLabel">Settings</h5>--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3">--}}
{{--                        <div class="card">--}}
{{--                            <h5 class="card-header border border-light">Change_Password</h5>--}}
{{--                            <div class="card-body border border-light">--}}
{{--                                <form method="POST" id="change-settings-user-password">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">--}}

{{--                                    <div class="row">--}}
{{--                                        <div class="col-12">--}}
{{--                                            <label for="current_password">Current_Password</label>--}}
{{--                                            <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Enter_Current_Password" value="{{ old('current_password') }}">--}}
{{--                                            <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12">--}}
{{--                                            <label for="newpassword">New_Password</label>--}}
{{--                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new_password" placeholder="Enter_New_Password">--}}
{{--                                            <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12">--}}
{{--                                            <label for="userpassword">Confirm_Password</label>--}}
{{--                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new_password" placeholder="Enter_New_Confirm_password">--}}
{{--                                            <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="mt-3 d-grid">--}}
{{--                                        <button class="btn btn-primary waves-effect waves-light APAGARUpdatePassword" data-id="{{ Auth::user()->id }}" type="submit">Update_Password</button>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
