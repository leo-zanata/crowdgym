@extends('layouts.dashboard')

@section('title', 'Cadastrar Academia')

@section('content')
    <main>
        <h1>Cadastrar Nova Academia</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.gyms.store') }}" method="POST">
            @csrf

            <div class="input-group">
                <div class="input-box">
                    <label for="gymName">Nome da Academia*</label>
                    <input type="text" name="gymName" placeholder="Digite o nome" id="gymName" maxlength="100" required
                        value="{{ old('gymName') }}" />
                    @error('gymName')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="managerName">Nome do(a) Gerente*</label>
                    <input type="text" name="managerName" placeholder="Digite o nome" id="managerName" maxlength="100"
                        required value="{{ old('managerName') }}" />
                    @error('managerName')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="gymPhone">Telefone da Academia*</label>
                    <input type="tel" name="gymPhone" maxlength="11" oninput="formatOnlyNumbers(this)"
                        placeholder="Digite o número" id="gymPhone" required value="{{ old('gymPhone') }}" />
                    @error('gymPhone')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="managerPhone">Telefone do(a) Gerente*</label>
                    <input type="tel" name="managerPhone" maxlength="11" oninput="formatOnlyNumbers(this)"
                        placeholder="Digite o número" id="managerPhone" required value="{{ old('managerPhone') }}" />
                    @error('managerPhone')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="email">E-mail do(a) Gerente*</label>
                    <input type="email" name="manager_email" placeholder="Digite o email" maxlength="255" id="email"
                        required value="{{ old('manager_email') }}" />
                    @error('manager_email')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="cpf">CPF*</label>
                    <input type="text" id="cpf" name="manager_cpf" maxlength="11" oninput="formatOnlyNumbers(this)"
                        placeholder="Digite o cpf" required value="{{ old('manager_cpf') }}" />
                    @error('manager_cpf')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-box" id="cep-box">
                    <label for="zipCode">CEP*</label>
                    <input type="text" id="zipCode" name="zipCode" oninput="formatOnlyNumbers(this)" maxlength="8"
                        placeholder="Digite o cep" required value="{{ old('zipCode') }}" />
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
                    <input type="text" name="neighborhood" id="neighborhood" required value="{{ old('neighborhood') }}">
                    @error('neighborhood') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="street">Rua*</label>
                    <input type="text" name="street" id="street" required value="{{ old('street') }}">
                    @error('street') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="number">Número*</label>
                    <input type="text" name="number" id="number" oninput="formatOnlyNumbers(this)" required
                        value="{{ old('number') }}">
                    @error('number') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="complement">Complemento</label>
                    <input type="text" name="complement" id="complement" value="{{ old('complement') }}">
                    @error('complement') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit">Cadastrar Academia</button>
        </form>
    </main>
@endsection
@section('js-files')
    <script src="{{ asset('js/auth/app.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
@endsection