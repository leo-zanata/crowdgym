<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Cadastro Usuário</title>
  <link rel="stylesheet" href="{{ asset('css/register_login.css') }}" />
</head>

<body>
  <main>
    <div class="container">
      <div class="form">
        <form action="{{ route('register') }}" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Crowd Gym</h1>
            </div>
          </div>
          <div class="form-subheader">
            <div class="subtitle">
              <h2>Cadastro de conta do aluno</h2>
            </div>
            <div class="subtitle-main">
              <p>Digite os seus dados para realizar o cadastro</p>
            </div>
          </div>
          @csrf <div class="input-group">
            <div class="input-box">
              <label for="name">Nome*</label>
              <input type="text" name="name" placeholder="Digite o nome" id="name" maxlength="100" required
                value="{{ old('name') }}" />
              @error('name')
          <span style="color: red;">{{ $message }}</span>
        @enderror
            </div>

            <div class="input-box">
              <label for="email">E-mail*</label>
              <input type="email" name="email" placeholder="Digite o email" maxlength="255" id="email" required
                value="{{ old('email') }}" />
              @error('email')
          <span style="color: red;">{{ $message }}</span>
        @enderror
            </div>

            <div class="input-box">
              <label for="cpf">CPF*</label>
              <input type="text" id="cpf" name="cpf" placeholder="00000000000" maxlength="11" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('cpf') }}">
              @error('cpf')
          <span style="color: red;">{{ $message }}</span>
        @enderror
            </div>

            <div class="input-box">
              <label for="birth">Data de Nascimento*</label>
              <input type="date" id="birth" name="birth" required value="{{ old('birth') }}">
              @error('birth')
          <span style="color: red;">{{ $message }}</span>
        @enderror
            </div>

            <div class="input-box">
              <label for="password">Senha*</label>
              <input type="password" name="password" placeholder="Digite a senha" maxlength="15" id="password"
                required />
              @error('password')
          <span style="color: red;">{{ $message }}</span>
        @enderror
            </div>

            <div class="input-box">
              <label for="password_confirmation">Confirme a Senha*</label>
              <input type="password" name="password_confirmation" placeholder="Digite a senha novamente" maxlength="15"
                id="password_confirmation" required />
            </div>

            <div class="gender-inputs">
              <div class="gender-title">
                <h6>Gênero*</h6>
              </div>

              <div class="gender-group">
                <div class="gender-input">
                  <input type="radio" name="gender" id="gender" value="feminino" required>
                  <label for="gender">Feminino</label>
                </div>

                <div class="gender-input">
                  <input type="radio" name="gender" id="gender" value="masculino" required>
                  <label for="gender">Masculino</label>
                </div>

                <div class="gender-input">
                  <input type="radio" name="gender" id="gender" value="outro" required>
                  <label for="gender">Outro</label>
                </div>
              </div>
            </div>
          </div>
          <div class="register-button">
            <input type="submit" value="Cadastrar Conta">
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>