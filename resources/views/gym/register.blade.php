@extends('layouts.app')

@section('title', 'Cadastro de Academia')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/gym/register.css') }}" />
@endsection
@section('links')
    @include('partials.whatsapp')
@endsection

@section('content')
    <div class="back-button">
        <a href="{{ url()->previous() }}"><i class="bi bi-arrow-left-circle"></i></a>
    </div>

    <div class="container">
        <div class="form-academia">
            <form action="{{ route('gym.store') }}" method="POST">
                @csrf
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-header">
                    <div class="title-main">
                        <h1>Crowd Gym</h1>
                    </div>
                    <div class="title-form">
                        <h2>Preencha o formulário para entrarmos em contato</h2>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="gymName">Nome da Academia*</label>
                        <input type="text" name="gym_name" placeholder="Digite o nome" id="gymName" maxlength="100" required
                            value="{{ old('gymName') }}" />
                        @error('gymName')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="managerName">Nome do(a) Gerente*</label>
                        <input type="text" name="manager_name" placeholder="Digite o nome" id="managerName" maxlength="100"
                            required value="{{ old('managerName') }}" />
                        @error('managerName')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="gymPhone">Telefone da Academia*</label>
                        <input type="tel" name="gym_phone" maxlength="11" placeholder="Digite o número" id="gymPhone"
                            required value="{{ old('gymPhone') }}" />
                        @error('gymPhone')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="managerPhone">Telefone do(a) Gerente*</label>
                        <input type="tel" name="manager_phone" maxlength="11" placeholder="Digite o número"
                            id="managerPhone" required value="{{ old('managerPhone') }}" />
                        @error('managerPhone')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail do(a) Gerente*</label>
                        <input type="email" name="manager_email" placeholder="Digite o email" maxlength="255" id="email"
                            required value="{{ old('email') }}" />
                        @error('email')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="cpf">CPF*</label>
                        <input type="text" id="cpf" name="manager_cpf" maxlength="11" placeholder="Digite o cpf" required
                            value="{{ old('cpf') }}" />
                        @error('cpf')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box" id="cep-box">
                        <label for="zipCode">CEP*</label>
                        <input type="text" id="zipCode" name="zip_code" maxlength="8" placeholder="Digite o cep" required
                            value="{{ old('zipCode') }}" />
                        @error('zipCode')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="state">Estado*</label>
                        <select id="state" name="state" required>
                            <option value="">Selecione um estado</option>
                            @foreach($states as $sigla => $nome)
                                <option value="{{ $sigla }}" {{ old('state') == $sigla ? 'selected' : '' }}>{{ $nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="city">Cidade*</label>
                        <select id="city" name="city" required>
                            <option value="{{ old('city') }}">
                                {{ old('city') ? old('city') : 'Selecione uma cidade' }}
                            </option>
                        </select>
                        @error('city')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="neighborhood">Bairro*</label>
                        <input type="text" name="neighborhood" placeholder="Digite o nome do bairro" id="neighborhood"
                            maxlength="100" required value="{{ old('neighborhood') }}" />
                        @error('neighborhood')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="street">Rua*</label>
                        <input type="text" name="street" placeholder="Digite o nome da rua" maxlength="100" id="street"
                            required value="{{ old('street') }}" />
                        @error('street')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="number">Numero*</label>
                        <input type="number" name="number" placeholder="Digite o numero" maxlength="10" id="number" required
                            value="{{ old('number') }}" />
                        @error('number')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="complement">Complemento - opcional</label>
                        <input type="text" name="complement" placeholder="Digite o complemento" id="complement"
                            maxlength="255" value="{{ old('complement') }}" />
                        @error('complement')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="opening">Horário de Abertura*</label>
                        <input type="time" id="opening" name="opening" required value="{{ old('opening') }}" />
                        @error('opening')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="closing">Horário de Fechamento*</label>
                        <input type="time" id="closing" name="closing" required value="{{ old('closing') }}" />
                        @error('closing')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="days-inputs">
                    <div class="days-title">
                        <h6>Dias de Funcionamento*</h6>
                    </div>
                    <div class="days-group">
                        <div class="days-input">
                            <input type="checkbox" id="monday" name="weekDays[]" value="Segunda" {{ in_array('Segunda', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="monday">Segunda</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="tuesday" name="weekDays[]" value="Terça" {{ in_array('Terça', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="tuesday">Terça</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="wednesday" name="weekDays[]" value="Quarta" {{ in_array('Quarta', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="wednesday">Quarta</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="thursday" name="weekDays[]" value="Quinta" {{ in_array('Quinta', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="thursday">Quinta</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="friday" name="weekDays[]" value="Sexta" {{ in_array('Sexta', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="friday">Sexta</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="saturday" name="weekDays[]" value="Sábado" {{ in_array('Sábado', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="saturday">Sábado</label>
                        </div>
                        <div class="days-input">
                            <input type="checkbox" id="sunday" name="weekDays[]" value="Domingo" {{ in_array('Domingo', old('weekDays', [])) ? 'checked' : '' }} />
                            <label for="sunday">Domingo</label>
                        </div>
                        @error('weekDays')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="register-button">
                    <input type="submit" id="enviarFormulario" value="Enviar Formulário">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js-files')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection