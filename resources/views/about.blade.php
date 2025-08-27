@extends('layouts.app')

@section('title', 'Sobre Nós')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/aluno/sobre_nos.css') }}">
@endsection

@section('content')
    <div class="texto1">
        <h1>Quem somos nós?</h1>
        <p>A <b>Zoltex</b> é uma empresa pequena focada em desenvolver e vender softwares para empresas. Nossos produtos têm como objetivo facilitar e otimizar as atividades da empresa. O <b>Crowd Gym</b> é nosso projeto mais recente.</b></p>
        <br>
    </div>

    <br>
    <div id="laranja"></div>
    <br>


    <div class="texto1">
        <h1>Nossa História</h1>

        <p>A Zoltex foi criada em 2023 como parte de um projeto de faculdade, que tinha como objetivo criarmos uma empresa e desenvolver um projeto que será o produto ou serviço dessa empresa.</p>
        <br>
        <p>Nosso primeiro projeto foi o Crowd Gym, que surgiu a partir da necessidade de existir um site que consiga monitorar o fluxo de entrada e saída das academias, permitindo que seus alunos possam planejar suas rotinas de treino em torno do seu dia-a-dia.<br>Essa necessidade foi percebida por um dos membros do grupo, que os aplicativos e sistemas já existentes no mercado eram exclusivos para algumas acadêmias, não eram precisos, e não forneciam tantos gráficos de lotação em certos períodos.</p>
        <br>
        <p>A partir dessa ideia e problema, com a ajuda de nossos professores ao longo dos semestre, fomos definindo melhor as características e identidade de nossa empresa, junto dos detalhes e funções do Crowd Gym. Esse site é o produto de nosso esforço coletivo, e planejamos apresenta-lo como o trabalho de graduação do curso.</p>
        <br>

        <h1>Nossa Missão, Visão e Valores</h1>
        <p>Nossa <b>Missão</b> é criar e vender softwares e sistemas que consigam suprir as necessidades das pessoas, sejam elas clientes ou empresários que buscam melhorar seu negócio, preenchendo as lacunas deixadas por outros produtos e softwares no mercado que não consigam satisfazer essas necessidades por completo.</p>
        <br>
        <p>Nossa <b>Visão</b> é ser um ponto de referência no ramo de desenvolvimento de softwares e sistemas como serviço, criando parcerias e pondo o cliente sempre em primeiro lugar em nossos projetos.</p>
        <br>
        <p>Nossos <b>Valores</b> são: dedicação em nossos projetos, sempre considerando o que o cliente precisa; análises bem-estruturadas do mercado; inovação e criatividade; conforto e conveniência.</p>
    </div>


    <br>
    <div id="laranja"></div>
    <br>


    <div class="texto1">
        <h1>Nossos Projetos</h1>
        <br>
        <h1>Crowd Gym</h1>

        <p>O Crowd Gym é um sistema que permite que as academias gerenciem o cadastro de alunos, monitorem o fluxo de entrada e saída, e acompanhem informações financeiras e de planos de assinatura. Ele oferece funcionalidades específicas para gerentes e funcionários, garantindo controle de acesso e uma experiência integrada para todos os usuários. Já os alunos têm acesso a uma interface onde podem se matricular em qualquer academia cadastrada, assinar planos, acompanhar os horários e dias de treinos realizados e visualizar em tempo real o fluxo de pessoas que estão presentes na academia, proporcionando uma experiência mais dinâmica e interativa para o usuário.</p><br>
        <p>Nosso site tem como principais usuários a equipe da academia, como a gerência e os funcionários administrativos, e os alunos que frequentam a academia. Alunos e a equipe da academia terão acessos diferentes, de acordo com suas necessidades.</p>
        <br>

        <h2>Quem pode acessar o quê no sistema?</h2>

        <h3>A Equipe da Academia (gerente e outros funcionários) pode acessar:</h3>
        <div class="lista1">
            <ul align="left">
                <li>Editar dados da academia <b>(exclusivo para o gerente)</b></li>
                <li>Visualisar os gráficos de lotação diários, semanais e mensais da academia</li>
                <li>Nome e informações de contato e assinatura dos alunos</li>
                <li>Gerenciar assinaturas oferecidas pela academia <b>(exclusivo para o gerente)</b></li>
            </ul>
        </div>

        <br>

        <div class="lista1">
            <h3>Os alunos podem acessar:</h3>
            <ul align="left">
                <li>Registro de treino semanal</li>
                <li>Gráficos Diários, Semanais e Mensais de Lotação de Academias</li>
                <li>Gerenciamento de assinatura de academia</li>
                <li>Edição de dados pessoais</li>
                <li>Informações sobre a academia</li>
                <li>Menu com academias em que está matrículado</li>
                <li>Pesquisa de academias que usam o Crowd Gym</li>
            </ul>
        </div>
    </div>
@endsection