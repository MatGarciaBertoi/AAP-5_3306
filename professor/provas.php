<!DOCTYPE html>
<html lang='pt-BR'>

<head>
    <link rel="stylesheet" media="all" href="S.css" />
    <style>
        .static-backdrop::before {
            background-image: url("https://d2ffu0zq97rhm7.cloudfront.net/fallback/cover_image/desktop-2.jpg");
        }
    </style>
    <link rel="shortcut icon" type="image/x-icon" href="https://d2ffu0zq97rhm7.cloudfront.net/fallback/brand_image/default.png" />

    <header>
        <nav class='navbar navbar-default customer-nav customer-brand-nav' role='navigation'>
            <div class='container'>



                <div class='collapse navbar-collapse' id='navbar-collapse-1'>
                    <ul class='nav navbar-nav navbar-right control-account'>
                        <li class='customer-info user-menu'>
                            <div>
                                <div class='profile-img-container'>
                                    <div class='info'>
                                        <span class='hello-customer'>Olá,</span>
                                        <span class='customer-name'>Professor(a)</span>
                                    </div>
                                    <img class="customer-img" src="https://d2ffu0zq97rhm7.cloudfront.net/fallback/profile_image/nav_img_default.png" alt="Nav img default" />
                                    <div class='show-menu arrow-down'></div>
                                </div>
                            </div>
                            <div class='customer-wrapper'>
                                <div class='customer-menu-box'>
                                    <div class='arrow-menu-up'></div>
                                    <p class='customer-email'>emailprofessor@cw.com</p>

                                    <ul class='customer-actions'>
                                        <li>
                                            <a href="perfil.html">Minha Conta</a>
                                        </li>

                                        <li>
                                            <a target="_blank" href="../Suporte/Suporte.html">Suporte</a>
                                        </li>
                                        <li>
                                            <a id="customer-dashboard-logout" rel="nofollow" data-method="delete" href="/sign_out">Sair</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <a id="sidebar-toogle-white" href="#"><span class='sr-only'>Toggle navigation</span>

        </a>
        <nav class='navbar navbar-default brand-nav' role='navigation'>
            <div class='menu-block'></div>
            <div class='submenu-block'></div>
            <div class='container'>
                <button class='navbar-toggle' data-target='#navbar-collapse-2' data-toggle='collapse' type='button'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbar-collapse-2'>
                    <ul class='nav navbar-nav navbar-left'></ul>
                </div>
            </div>
        </nav>
        <div class='new-customer-nav'>
            <div class='container'>
                <div class='mainnav mainnav-pt-BR' id='mainnav' role='navigation'>
                    <ul>
                        <li class='mainnav-item nav-li nav-li-js' id='mainnav-panel'>
                            <a class="mainnav-item-link" href="../Painel professor/forum.html">Forum de duvidas
                            </a>
                        </li>

                        <li class='mainnav-item nav-li nav-li-js' id='mainnav-my-courses'>
                            <a class="mainnav-item-link" href="../Painel professor/index.html">Meus cursos
                                </span>
                            </a>
                            <div class='nav-arrow nav-arrow-js'></div>
                            <div class='subnav nav-sub nav-sub-js'>
                                <ul class='subCMSListMenuUL' id='CMSListMenu3'>
                                    <li class='subCMSListMenuLI'>
                                        <a class="subCMSListMenuLink" href="../Painel professor/index.html">Todos os cursos</a>
                                    </li>
                                    <li class='subCMSListMenuLI'>
                                        <a class="subCMSListMenuLink linkSecondColor" href="../Painel professor/provas.html">Provas
                                            </span>
                                        </a>
                                    </li>
                                    <li class='subCMSListMenuLI'>
                                        <a class="subCMSListMenuLink linkSecondColor" href="/customer/brand/certificates">Notas de atividades
                                            </span>
                                        </a>
                                    </li>

                                    <li class='subCMSListMenuLI'>
                                        <a class="subCMSListMenuLink linkSecondColor" id="create-a-new-course" data-remote="true" href="../Painel professor/novocurso.html"><span aria-hidden='true' class='glyphicon glyphicon-plus'></span>
                                            Adicionar curso
                                        </a>
                                    </li>
                                </ul>
                            </div>





    </header>
    <main>
        <div class='container'>
            <div class='row' id='yield-content'>
                <div class='col-md-12'>
                    <div class='row'>
                        <div class='col-md-12 text-center'>
                            <p class='lead'>Provas</p>
                        </div>
                        <div id='quizzes-list'>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-8 col-xs-12'>
                                        <a class="btn btn-primary btn-add-new-quizzes" href="novaprova.html">
                                            <i class='glyphicon glyphicon-plus'></i>
                                            Nova prova

                                        </a>
                                    </div>
                                    <div class='col-md-4 col-xs-12'>
                                        <form id="search-form" action="/customer/brand/exams" accept-charset="UTF-8" method="get">
                                            <input name="utf8" type="hidden" value="&#x2713;" />
                                            <div class='input-group'>
                                                <input type="text" name="search" id="search" placeholder="Buscar provas" class="form-control search-student-input" />
                                                <span class='input-group-btn'>
                                                    <button type="submit" class="btn">
                                                        <span class='fui-search'></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class='col-md-12'>
                                        <div class='box box-content' id='quizzes-list'>
                                            <div class='box box-table box-content' id='students-list'>
                                                <table class='table table-striped table-hover'>
                                                    <thead class='course-students-header'>
                                                        <tr>
                                                            <td colspan='5'>
                                                                <p class='title'>Provas (0)</p>
                                                                <p class='subtitle'>Exibindo todos as provas da escola</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nome da prova
                                                            </th>
                                                            <th>Total de respostas recebidas
                                                            </th>
                                                            <th>Status
                                                            </th>
                                                            <th>Cadastrado
                                                            </th>
                                                            <th>Ações
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="line-height: normal">
                                                                Prova teste
                                                            </td>
                                                            <td style="line-height: normal">
                                                                <a href="/customer/brand/exams/769/student_exams">0</a>
                                                            </td>
                                                            <td style="line-height: normal">
                                                                <span class="label label-success">
                                                                    Publicado
                                                                </span>
                                                            </td>
                                                            <td style="line-height: normal">
                                                                07/10/2024 00:52
                                                            </td>
                                                            <td>
                                                                <div class="col action-button-custom-fields">
                                                                    <a class="btn btn-inverse btn-xs" href="/customer/brand/exams/769/student_exams"><i class="glyphicon glyphicon-eye-open"></i>
                                                                        <span>
                                                                            Visualizar respostas
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="col action-button-custom-fields">
                                                                    <a class="btn btn-inverse btn-xs" href="/customer/brand/exams/769/edit"><i class="glyphicon glyphicon-edit"></i>
                                                                        <span>
                                                                            Editar
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="col action-button-custom-fields">
                                                                    <a data-confirm="Você tem certeza?" class="btn btn-inverse btn-xs" rel="nofollow" data-method="delete" href="/customer/brand/exams/769"><i class="glyphicon glyphicon-trash"></i>
                                                                        <span>
                                                                            Excluir
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class='col-xs-12 paginte-student text-right'>
                                            <div class='row'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    </body>

</html>