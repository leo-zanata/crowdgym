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
                    <input type="text" name="gymName" id="gymName" required value="{{ old('gymName') }}">
                    @error('gymName') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="gymPhone">Telefone da Academia*</label>
                    <input type="text" name="gymPhone" id="gymPhone" required value="{{ old('gymPhone') }}">
                    @error('gymPhone') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="zipCode">CEP*</label>
                    <input type="text" name="zipCode" id="zipCode" required value="{{ old('zipCode') }}">
                    @error('zipCode') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="state">Estado*</label>
                    <input type="text" name="state" id="state" required value="{{ old('state') }}">
                    @error('state') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="city">Cidade*</label>
                    <input type="text" name="city" id="city" required value="{{ old('city') }}">
                    @error('city') <span class="text-red-500">{{ $message }}</span> @enderror
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
                    <input type="text" name="number" id="number" required value="{{ old('number') }}">
                    @error('number') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="complement">Complemento</label>
                    <input type="text" name="complement" id="complement" value="{{ old('complement') }}">
                    @error('complement') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="opening">Horário de Abertura*</label>
                    <input type="time" name="opening" id="opening" required value="{{ old('opening') }}">
                    @error('opening') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="input-box">
                    <label for="closing">Horário de Fechamento*</label>
                    <input type="time" name="closing" id="closing" required value="{{ old('closing') }}">
                    @error('closing') <span class="text-red-500">{{ $message }}</span> @enderror
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
            </div>

            <button type="submit">Cadastrar Academia</button>
        </form>
    </main>
@endsection