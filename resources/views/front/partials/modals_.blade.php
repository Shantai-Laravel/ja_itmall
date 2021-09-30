<div class="modals">
    <div class="modal" id="commandSet">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody">
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="title col-12">precomanda</div>
                    <div class="col-12">
                        <div class="row modalHeader justify-content-around">
                            <div class="col-auto headTab guestTab active">
                                As Guest
                            </div>
                            <div class="col-auto headTab registerTab">
                                Register
                            </div>
                            <div class="col-auto headTab signinTab ">
                                Sign in
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 guestBloc activeBloc">
                        <input type="text" placeholder="Nume si prenume" />
                        <input type="text" placeholder="E-mail" />
                        <input type="text" placeholder="Telefon" />
                        <input type="submit" class="butt buttView" value="Trimite" />
                    </div>
                    <div class="col-md-12 signinBloc">
                        <div class=" loginBy loginByRegister">
                            <a href="#"><span>Login by</span></a>
                            <a href="#"><span>Login by</span></a>
                        </div>
                        <input type="text" placeholder="Nume si prenume" />
                        <input type="password" placeholder="Parola" />
                        <p data-target="#forgetPassword" data-toggle="modal" data-dismiss="modal">
                            Ai uitat parola? <span>Apasa aici.</span>
                        </p>
                        <input type="submit" class="butt buttView" value="sign in" />
                    </div>
                    <div class="col-12 registerBloc">
                        <input type="text" placeholder="Nume si prenume" />
                        <div class="telefonGroup">
                            <span></span>
                            <select name="">
                                <option value="rm">+373</option>
                                <option value="rm">Russia</option>
                                <option value="rm">Romania</option>
                            </select>
                            <input type="text" placeholder="Telefon" />
                        </div>
                        <input type="password" placeholder="Parola" />
                        <input type="password" placeholder="Repeta Parola" />
                        <label class="containerFilter"
                            >Sunt de acord cu procesarea datelor personale
                        <input type="checkbox" />
                        <span class="checkmark"></span>
                        </label>
                        <input type="submit" class="butt buttView" value="Register" />
                        <p class="text-center">
                            Quick acces with:
                        </p>
                        <div class=" loginBy loginByRegister">
                            <a href="#"><span>Login by</span></a>
                            <a href="#"><span>Login by</span></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="register">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody">
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="title col-12">inregistrare</div>
                    <div class="col-md-12">
                        <div class=" loginBy loginByRegister">
                            <a href="#"><span>Login by</span></a>
                            <a href="#"><span>Login by</span></a>
                        </div>
                        <input type="text" placeholder="Nume si prenume" />
                        <div class="telefonGroup">
                            <span></span>
                            <select name="">
                                <option value="rm">+373</option>
                                <option value="rm">Russia</option>
                                <option value="rm">Romania</option>
                            </select>
                            <input type="text" placeholder="Telefon" />
                        </div>
                        <input type="password" placeholder="Parola" />
                        <input type="password" placeholder="Repeta Parola" />
                    </div>
                    <div class="col-12">
                        <label class="containerFilter"
                            >Sunt de acord cu procesarea datelor personale
                        <input type="checkbox" />
                        <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="butt buttView" value="trimite comanda" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (!Auth::guard('persons')->user())
    {{-- Auth modal --}}
    <div class="modal" id="login">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody">
                    <div class="closeModal" data-dismiss="modal"></div>
                    @if (!is_null($unloggedUser))
                        <auth guest="{{ json_encode($unloggedUser) }}"></auth>
                    @else
                        <auth guest="{{ null }}"></auth>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Forget Password modal --}}
    <div class="modal" id="forgetPassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <reset-password></reset-password>
            </div>
        </div>
    </div>

    <div class="modal" id="commandProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody">
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="title col-12">comanda produs</div>
                    <div class="col-md-12">
                        <input type="text" placeholder="Nume / Prenume" />
                        <input type="text" placeholder="Denumirea companiei" />
                        <input type="text" placeholder="Nr. Telefon" />
                    </div>
                    <div class="col-12">
                        <input type="submit" class="butt buttView" value="trimite comanda" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (Session::has('succes'))
<div class="modal" id="modalSucces">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row modalBody">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="title col-12">precomanda</div>
                <div class="col-md-12 text-center">
                    <p>{{ Session::get('succes') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
