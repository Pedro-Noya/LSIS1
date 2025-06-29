# Commits by author
#### 1222066@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /atualizar_perfil.php                                          |   12 
 /atualizar_perfil_bll.php                                      |   56 
 /atualizar_perfil_dal.php                                      |   22 
 /dashboard.php                                                 |   59 
 /dashboard_bll.php                                             |   28 
 /dashboard_dal.php                                             |   27 
 /login_bll.php                                                 |   64 +
 /login_dal.php                                                 |   27 
 /styles_atualizar_perfil.css                                   |  115 +
 3.php                                                          |  237 ---
 6.php                                                          |    3 
 BLL/Login_Utilizador_BLL.php                                   |   32 
 BLL/Registo_Utilizador_BLL.php                                 |   61 -
 BLL/atualizar_perfil_bll.php                                   |  314 ++++!
 CSS/registar.css                                               |  136 --
 DAL/Atualizar_Perfil_DAL.php                                   |   29 
 DAL/Login_Utilizador_DAL.php                                   |   20 
 DAL/Registo_Utilizador_DAL.php                                 |   44 
 DAL/atualizar_perfil_dal.php                                   |  112 +
 GitAnalysis/Sprint_1/Commits.md                                |  119 -
 GitAnalysis/Sprint_1/Contributions.md                          |   22 
 JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js |   15 
 JS/Registo_Utilizador_Opcoes_Extra/registar.js                 |   14 
 JS/capsLockWarning.js                                          |   39 
 a/dashboard.php                                                |   76 -
 a/dashboard_bll.php                                            |   15 
 a/login_bll.php                                                |   64 -
 a/login_dal.php                                                |   27 
 a/styles_atualizar_perfil.css                                  |  102 -
 atualizar.php                                                  |  101 -
 atualizar_perfil.php                                           |   13 
 atualizar_perfil_bll.php                                       |  598 +++----!!
 atualizar_perfil_dal.php                                       |  307 +---
 b/6.php                                                        |    3 
 b/BLL/atualizar_perfil_bll.php                                 |  106 +
 b/DAL/atualizar_perfil_dal.php                                 |   14 
 b/atualizar_perfil.php                                         |    1 
 b/atualizar_perfil_bll.php                                     |   14 
 b/atualizar_perfil_dal.php                                     |   50 
 b/dashboard.php                                                |   77 !
 b/dashboard_bll.php                                            |   33 
 b/dashboard_completo.php                                       |  120 ++
 b/dashboard_dal.php                                            |    1 
 b/login.php                                                    |   40 
 b/login_aux.php                                                |   53 
 b/login_bll.php                                                |   64 +
 b/login_dal.php                                                |   27 
 b/styles.css                                                   |   23 
 b/styles_atualizar_perfil.css                                  |  112 +
 b/styles_dashboard.css                                         |   72 -
 dashboard.php                                                  |  304 ---!
 dashboard_bll.php                                              |  185 ++
 dashboard_completo.php                                         |  120 --
 dashboard_dal.php                                              |   29 
 index.php                                                      |   13 
 login.php                                                      |   53 
 login_aux.php                                                  |   53 
 login_bll.php                                                  |   64 -
 login_dal.php                                                  |   27 
 passReset.php                                                  |  129 --
 registar.php                                                   |  150 --
 styles.css                                                     |  125 --
 styles_dashboard.css                                           |  125 --
 63 files changed, 1822 insertions(+), 2794 deletions(-), 481 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 042ad7bd7c4bad9c7619d66c7d97d7fe3f039db2	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jun 29 15:07:13 2025 +0100

    Perspetiva do coordenador na página de atualizar_perfil.php realizada

M	BLL/atualizar_perfil_bll.php

commit 62b61bb3b51aaf31ca3400dd8049d4eaec3dac1a	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 23:48:06 2025 +0100

    Mais alterações à página de dashboard

M	dashboard.php
M	dashboard_bll.php

commit 5787ce0571da682bb7f1294877769df304a7db39	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 18:41:26 2025 +0100

    Página de Dashboard "Completa". Falta CSS

M	dashboard.php
M	dashboard_bll.php
M	dashboard_dal.php

commit 8c79b07bd6cf4c40df3d27a20a6861bf83025d97	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 17:05:56 2025 +0100

    Dois gráficos funcionais criados

M	dashboard.php
M	dashboard_bll.php

commit 4ab1969d7139f2a838b6be4f300d46a0f2d5a3fb	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 17:01:11 2025 +0100

    Update à página de dashboard

M	dashboard.php
M	dashboard_bll.php
M	dashboard_dal.php

commit 0d56c7dc5fb5bfafa15232725d9055759586f49b	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 15:54:54 2025 +0100

    Página de atualizar perfil 100% funcional

M	BLL/atualizar_perfil_bll.php

commit de1c1b61a79645e88e0dfff293f8326c321e0c5f	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 15:30:03 2025 +0100

    Página atualizar perfil concluída

M	BLL/atualizar_perfil_bll.php
M	DAL/atualizar_perfil_dal.php

commit 1dac203f7daddf3b32dd8c8a8d97a896412c2e87	refs/remotes/origin/Tiago
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jun 28 15:03:30 2025 +0100

    Dashboard avançada (já tem um gráfico funcional)

M	dashboard.php
M	dashboard_bll.php
M	dashboard_dal.php

commit b14b763bd9356f3d51f46b95ed09d561efaa42fa	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jun 27 22:47:55 2025 +0100

    Quase-conclusão da página de atualizar perfil

M	BLL/atualizar_perfil_bll.php
M	DAL/atualizar_perfil_dal.php

commit d3295a84a4aff42ac370d49c944f930767f071c6	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jun 27 13:02:58 2025 +0100

    Página Atualizar Perfil quase concluída

M	BLL/atualizar_perfil_bll.php
M	DAL/atualizar_perfil_dal.php
M	dashboard.php
A	dashboard_bll.php
A	dashboard_dal.php
D	login_aux.php
D	login_bll.php
D	login_dal.php

commit b6bd659650f970fde9eff889d70c9121229a3caa	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jun 27 10:34:45 2025 +0100

    Adicionar Login auxiliar

A	login_aux.php
A	login_bll.php
A	login_dal.php
M	styles_atualizar_perfil.css

commit 47bc94e013c9db9cd9c7309d66313cdf4e56c986	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jun 27 10:13:19 2025 +0100

    Ficheiro CSS add

A	styles_atualizar_perfil.css

commit 0f3598a0d723e22d57bf7be7abc41d64c7b0ea20	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jun 27 09:42:41 2025 +0100

    Ola

D	atualizar_perfil.php
D	atualizar_perfil_bll.php
D	atualizar_perfil_dal.php
D	dashboard.php
D	dashboard_bll.php
D	dashboard_completo.php
D	login.php
D	login_bll.php
D	login_dal.php
D	styles.css
D	styles_atualizar_perfil.css
D	styles_dashboard.css

commit 0ce2beb1ff1f853613a3e7a8594682d2ac78eb4a	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 22:00:01 2025 +0100

    Já atualiza todos os dados de uma vez (não se consideram envios de documentos ainda)

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php

commit 0349eda873655e0ed4d2d1b01b05b2c121a11a4e	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 20:56:51 2025 +0100

    Já atualiza alguns campos

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php

commit 83582534e2f9a96be4dffc12d2d4a1f36229a6c0	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 18:40:42 2025 +0100

    Primeira parte da atualização quase feita

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php
M	styles_atualizar_perfil.css

commit 0f1b8294cbaf1de00890de07c5b54c0b966e9aa0	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 15:05:10 2025 +0100

    Mais mudanças

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php

commit ec400bcadfa22b57e3821a114ae038aa1a8fc3f3	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 13:08:22 2025 +0100

    Criação de funções para obter dados para os dropdowns

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php

commit 766ca16780314c0d1421c3cadd1b42e6638c30c7	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jun 26 11:29:07 2025 +0100

    Select statement improved

M	atualizar_perfil_dal.php

commit 4a24b605c11075e04a20cc9e0e00c6f85a18cf31	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 22:44:36 2025 +0100

    Mais update

M	atualizar_perfil_bll.php
M	atualizar_perfil_dal.php

commit 73e74f559a678fb3edf4fb6e818c42de25dc56d6	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 18:37:55 2025 +0100

    Parte do design "completada"

M	atualizar_perfil_bll.php
M	styles_atualizar_perfil.css

commit 00e2a115aa67047a1ae777727db407f818335203	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 16:33:30 2025 +0100

    Mais Css

M	atualizar_perfil_bll.php
M	dashboard.php
A	dashboard_completo.php
M	styles_atualizar_perfil.css

commit 3b5f93d7ae5939171f026bbbe9f11000a2c77496	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 10:13:36 2025 +0100

    Mais alterações css

M	atualizar_perfil_bll.php
M	styles_atualizar_perfil.css

commit 96f0e9a0209d7e7cf865ec8e56851f95b9625a98	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 09:49:51 2025 +0100

    Mais css

M	atualizar_perfil_bll.php
M	styles_atualizar_perfil.css

commit 63ffd2dd64e5888d74cda384fa0f9dc0962fbb6b	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 09:39:10 2025 +0100

    Mais estilo

M	styles_atualizar_perfil.css

commit f2632eddcd129a45b614f552be0d718cc7d1a1d4	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 09:36:07 2025 +0100

    Estilo adicionado à página

M	atualizar_perfil_bll.php

commit 02df08bcf9d1edbfef73f241fc6cf604dfb9b02a	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 09:26:09 2025 +0100

    Alteração a atualizar perfil

M	atualizar_perfil.php
M	atualizar_perfil_bll.php
A	styles_atualizar_perfil.css

commit b3c0fb6c171a10cfd67281995f571c2d988fff95	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 08:28:15 2025 +0100

    O conteúdo da pasta "LSIS1" foi passada para esta pasta "PortalColaborador"

D	3.php
D	6.php
D	BLL/Atualizar_Perfil_BLL.php
D	BLL/Login_Utilizador_BLL.php
D	BLL/Registo_Utilizador_BLL.php
D	CSS/registar.css
D	DAL/Atualizar_Perfil_DAL.php
D	DAL/Login_Utilizador_DAL.php
D	DAL/Registo_Utilizador_DAL.php
D	GitAnalysis/Sprint_1/Commits.md
D	GitAnalysis/Sprint_1/Contributions.md
D	JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js
D	JS/Registo_Utilizador_Opcoes_Extra/registar.js
D	JS/capsLockWarning.js
D	atualizar.php
A	atualizar_perfil.php
A	atualizar_perfil_bll.php
A	atualizar_perfil_dal.php
A	dashboard.php
A	dashboard_bll.php
D	index.php
M	login.php
A	login_bll.php
A	login_dal.php
D	passReset.php
D	registar.php
R084	CSS/login.css	styles.css
R050	4.php	styles_dashboard.css

commit 5aaadbd053b1b77bbae8cb4aea486cd710769090	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jun 25 08:25:14 2025 +0100

    criei um ficheiro para testar se a branch funciona

A	6.php
</pre>

</details>

#### 1231113@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /CSS/equipas.css       |  125 +++++++++++++++++++++++++++++++++++++++++++++++++
 CSS/global.css         |   15 +++!!
 b/CSS/equipas.css      |    4 -
 b/CSS/global.css       |  104 ++++++++++++++++++!!!!!!!!!!!!!!!!!!!!!!
 b/CSS/login.css        |   76 ++++++++++++++++++!!!!!!!!!!!
 b/CSS/registar.css     |   74 ++++++++++++++++!!!!!!!!!!!!!
 b/Equipas/equipas.php  |    1 
 b/atualizar_perfil.php |    2 
 8 files changed, 271 insertions(+), 4 deletions(-), 126 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit b3a846d7a05e565f984ac2dd50488789b2c72417	refs/remotes/origin/Andre (origin/Andre)
Author: André Silva <1231113@isep.ipp.pt>
Date:   Sat Jun 28 16:48:12 2025 +0100

    CSS styling updates

M	CSS/global.css
M	CSS/login.css
M	CSS/registar.css

commit c000502a522a10cd6098f9f34003634e924f8490	refs/remotes/origin/Andre
Author: André Silva <1231113@isep.ipp.pt>
Date:   Fri Jun 27 11:18:31 2025 +0100

    Modifcação do CSS global

M	CSS/equipas.css
M	CSS/global.css

commit d7b38d69fb4782d8d9ca92fc1f26337d2769d9af	refs/remotes/origin/Andre
Author: André Silva <1231113@isep.ipp.pt>
Date:   Fri Jun 27 11:13:57 2025 +0100

    CSS de equipas

A	CSS/equipas.css
M	Equipas/equipas.php

commit 2795af6c3a8b9e65e56319e89895f2c3f67a7ea1	refs/remotes/origin/Andre
Author: André Silva <1231113@isep.ipp.pt>
Date:   Fri Jun 27 10:16:05 2025 +0100

    teste

M	atualizar_perfil.php
</pre>

</details>

#### pedrodefreitasnoya@gmail.com
<details>
<summary>Diff</summary>

<pre>
 /Equipas/equipas.php                                             |   73 
 /Equipas/equipasElementos.php                                    |  110 
 /Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js     |    9 
 /atualizar_perfil.php                                            |   13 
 /listar_trabalhadores.php                                        |  166 
 BLL/Login_Utilizador_BLL.php                                     |    9 
 BLL/Registo_Utilizador_BLL.php                                   |   98 
 CSS/login.css                                                    |    4 
 CSS/registar.css                                                 |    2 
 DAL/Login_Utilizador_DAL.php                                     |    1 
 DAL/Registo_Utilizador_DAL.php                                   |   12 
 Equipas/equipas.php                                              |    6 
 JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js   |   14 
 a/atualizar_perfil.php                                           |   26 
 a/login.php                                                      |  106 
 atualizar.php                                                    |    1 
 atualizar_perfil_bll.php                                         |  256 
 atualizar_perfil_dal.php                                         |   44 
 b/BLL/Equipas_BLL.php                                            |   27 
 b/BLL/Equipas_Elementos_BLL.php                                  |   70 
 b/BLL/Global_BLL.php                                             |   22 
 b/BLL/Listar_Trabalhadores_BLL.php                               |   94 
 b/BLL/Login_Utilizador_BLL.php                                   |    5 
 b/BLL/Registo_Utilizador_BLL.php                                 |    8 
 b/BLL/atualizar_perfil_bll.php                                   |    2 
 b/CSS/global.css                                                 |   95 
 b/CSS/listar_trabalhadores.css                                   |   98 
 b/CSS/login.css                                                  |   89 
 b/CSS/registar.css                                               |   88 
 b/DAL/Equipas_DAL.php                                            |   32 
 b/DAL/Equipas_Elementos_DAL.php                                  |  136 
 b/DAL/Global_DAL.php                                             |   26 
 b/DAL/Listar_Trabalhadores_DAL.php                               |   94 
 b/DAL/Login_Utilizador_DAL.php                                   |   17 
 b/DAL/Registo_Utilizador_DAL.php                                 |   18 
 b/DAL/atualizar_perfil_dal.php                                   |    4 
 b/Equipas/equipas.php                                            |    2 
 b/Equipas/equipasElementos.php                                   |    2 
 b/Imagens/mailLogo.png                                           |binary
 b/JS/capsLockWarning.js                                          |    2 
 b/JS/listar_trabalhadores.js                                     |   69 
 b/JS/login.js                                                    |    9 
 b/atualizar.php                                                  |    2 
 b/atualizar_perfil.php                                           |    3 
 b/composer.json                                                  |    5 
 b/composer.lock                                                  |  100 
 b/dashboard.php                                                  |   19 
 b/definir_nivel.php                                              |   17 
 b/definir_papel.php                                              |   17 
 b/formacoes.php                                                  |   10 
 b/index.php                                                      |    1 
 b/listar_trabalhadores.php                                       |    1 
 b/login.php                                                      |   17 
 b/logout.php                                                     |   15 
 b/passReset.php                                                  |    1 
 b/registar.php                                                   |   15 
 b/styles.css                                                     |  126 
 b/vendor/autoload.php                                            |   22 
 b/vendor/composer/ClassLoader.php                                |  579 +
 b/vendor/composer/InstalledVersions.php                          |  396 
 b/vendor/composer/LICENSE                                        |   21 
 b/vendor/composer/autoload_classmap.php                          |   10 
 b/vendor/composer/autoload_namespaces.php                        |    9 
 b/vendor/composer/autoload_psr4.php                              |   10 
 b/vendor/composer/autoload_real.php                              |   38 
 b/vendor/composer/autoload_static.php                            |   36 
 b/vendor/composer/installed.json                                 |   90 
 b/vendor/composer/installed.php                                  |   32 
 b/vendor/composer/platform_check.php                             |   26 
 b/vendor/phpmailer/phpmailer/COMMITMENT                          |   46 
 b/vendor/phpmailer/phpmailer/LICENSE                             |  502 
 b/vendor/phpmailer/phpmailer/README.md                           |  232 
 b/vendor/phpmailer/phpmailer/SECURITY.md                         |   37 
 b/vendor/phpmailer/phpmailer/SMTPUTF8.md                         |   48 
 b/vendor/phpmailer/phpmailer/VERSION                             |    1 
 b/vendor/phpmailer/phpmailer/composer.json                       |   80 
 b/vendor/phpmailer/phpmailer/get_oauth_token.php                 |  182 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-af.php      |   26 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ar.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-as.php      |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-az.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ba.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-be.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-bg.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-bn.php      |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ca.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-cs.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-da.php      |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-de.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-el.php      |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-eo.php      |   26 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php      |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-et.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fa.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fi.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fo.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fr.php      |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-gl.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-he.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hi.php      |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hr.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hu.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hy.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-id.php      |   31 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-it.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ja.php      |   37 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ka.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ko.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ku.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-lt.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-lv.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-mg.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-mn.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ms.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-nb.php      |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-nl.php      |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pl.php      |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt.php      |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php   |   38 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ro.php      |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ru.php      |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-si.php      |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sk.php      |   30 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sl.php      |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sr.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sr_latn.php |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sv.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-tl.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-tr.php      |   38 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-uk.php      |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ur.php      |   30 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-vi.php      |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-zh.php      |   29 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-zh_cn.php   |   36 
 b/vendor/phpmailer/phpmailer/src/DSNConfigurator.php             |  245 
 b/vendor/phpmailer/phpmailer/src/Exception.php                   |   40 
 b/vendor/phpmailer/phpmailer/src/OAuth.php                       |  139 
 b/vendor/phpmailer/phpmailer/src/OAuthTokenProvider.php          |   44 
 b/vendor/phpmailer/phpmailer/src/PHPMailer.php                   | 5362 ++++++++++
 b/vendor/phpmailer/phpmailer/src/POP3.php                        |  469 
 b/vendor/phpmailer/phpmailer/src/SMTP.php                        | 1547 ++
 dashboard.php                                                    |  152 
 dashboard_bll.php                                                |   30 
 dashboard_completo.php                                           |  240 
 index.php                                                        |   24 
 login.php                                                        |   15 
 login_bll.php                                                    |  128 
 login_dal.php                                                    |   54 
 registar.php                                                     |  151 
 styles.css                                                       |  376 
 styles_atualizar_perfil.css                                      |  166 
 styles_dashboard.css                                             |  250 
 152 files changed, 13580 insertions(+), 2168 deletions(-), 102 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 727922da83bc30facb9acc9fd99fce5fb63d9815	refs/heads/master (HEAD -> master, tag: sprint-3-entrega, origin/master, origin/HEAD)
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jun 29 18:57:04 2025 +0100

    commit final do sprint 3

M	Equipas/equipas.php

commit 6865b3ae86bcb2e9d40c3df344477aa8bba6afff	refs/remotes/origin/Tiago (origin/Tiago)
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jun 29 18:48:32 2025 +0100

    fix de 1 parentisis }

M	BLL/atualizar_perfil_bll.php

commit 2538fa9030354410411536487dedc886cb886e99	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jun 29 18:41:40 2025 +0100

    fix da data de criaçao das equipas aparecer como
    00-00-0000
    
    funcionalidade de listar trabalhadores e
    alterar o seu estado
    
    css listar_trabalhadores

A	CSS/listar_trabalhadores.css
M	Equipas/equipas.php
M	listar_trabalhadores.php

commit ade30abc2c8d324da37cc380b2e7ced937e11a0d	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jun 29 05:22:25 2025 +0100

    password automaticamente gerada, login de coordenador/ alteração do papel para coordenador adiciona (se ainda nao existir) um elemento na tabela coordenador, página para listar trabalhadores com filtros e funcionalidade de editar cada colaborador, páginas de auxilio para criar codigo php atravez de js

A	BLL/Listar_Trabalhadores_BLL.php
M	BLL/Login_Utilizador_BLL.php
A	DAL/Listar_Trabalhadores_DAL.php
M	DAL/Login_Utilizador_DAL.php
A	JS/listar_trabalhadores.js
M	atualizar_perfil.php
A	definir_nivel.php
A	definir_papel.php
A	listar_trabalhadores.php
M	login.php

commit 39c0f8ea2aa5af4dc286e74924466fa2bcf08903	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sat Jun 28 03:36:36 2025 +0100

    palavra passe automatica, emails enviados para email do grupo 5

M	BLL/Login_Utilizador_BLL.php
M	BLL/Registo_Utilizador_BLL.php
M	Equipas/equipas.php
M	login.php
M	registar.php

commit 4b12c1101e312c84bb906c8a369b5d5ac15074d6	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 27 22:54:47 2025 +0100

    Página de Registo Aprimorada
    Sistema de Envio de Email Funcional após o registo, que liga à página de login com o email já preenchido. (phpmailer)

M	BLL/Registo_Utilizador_BLL.php
M	DAL/Registo_Utilizador_DAL.php
A	Imagens/mailLogo.png
D	JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js
A	JS/login.js
A	composer.json
A	composer.lock
M	login.php
M	registar.php
A	vendor/autoload.php
A	vendor/composer/ClassLoader.php
A	vendor/composer/InstalledVersions.php
A	vendor/composer/LICENSE
A	vendor/composer/autoload_classmap.php
A	vendor/composer/autoload_namespaces.php
A	vendor/composer/autoload_psr4.php
A	vendor/composer/autoload_real.php
A	vendor/composer/autoload_static.php
A	vendor/composer/installed.json
A	vendor/composer/installed.php
A	vendor/composer/platform_check.php
A	vendor/phpmailer/phpmailer/COMMITMENT
A	vendor/phpmailer/phpmailer/LICENSE
A	vendor/phpmailer/phpmailer/README.md
A	vendor/phpmailer/phpmailer/SECURITY.md
A	vendor/phpmailer/phpmailer/SMTPUTF8.md
A	vendor/phpmailer/phpmailer/VERSION
A	vendor/phpmailer/phpmailer/composer.json
A	vendor/phpmailer/phpmailer/get_oauth_token.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-af.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ar.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-as.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-az.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ba.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-be.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-bg.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-bn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ca.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-cs.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-da.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-de.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-el.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-eo.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-et.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fa.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fo.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-gl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-he.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hu.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hy.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-id.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-it.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ja.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ka.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ko.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ku.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-lt.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-lv.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-mg.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-mn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ms.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-nb.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-nl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pt.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ro.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ru.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-si.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sk.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sr_latn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sv.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-tl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-tr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-uk.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ur.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-vi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-zh.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-zh_cn.php
A	vendor/phpmailer/phpmailer/src/DSNConfigurator.php
A	vendor/phpmailer/phpmailer/src/Exception.php
A	vendor/phpmailer/phpmailer/src/OAuth.php
A	vendor/phpmailer/phpmailer/src/OAuthTokenProvider.php
A	vendor/phpmailer/phpmailer/src/PHPMailer.php
A	vendor/phpmailer/phpmailer/src/POP3.php
A	vendor/phpmailer/phpmailer/src/SMTP.php

commit 00527a0447a2b4d6dda8e60b25ae3f9cccb739d3	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 27 11:35:28 2025 +0100

    branch vazio

D	atualizar_perfil.php
D	atualizar_perfil_bll.php
D	atualizar_perfil_dal.php
D	dashboard.php
D	dashboard_bll.php
D	dashboard_completo.php
D	login.php
D	login_bll.php
D	login_dal.php
D	styles.css
D	styles_atualizar_perfil.css
D	styles_dashboard.css

commit 95fae3b1411dde03ea71873c00ea6c6262ec1b0f	refs/remotes/origin/Andre
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 27 09:39:30 2025 +0100

    merge (branches teste+Tiago)

R097	atualizar_perfil_bll.php	BLL/atualizar_perfil_bll.php
R096	atualizar_perfil_dal.php	DAL/atualizar_perfil_dal.php
A	atualizar_perfil.php
M	index.php
D	styles.css

commit bcb66b9d6a5149292e1e95af8770eb9bf9e17d66	refs/remotes/origin/Andre
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 27 08:45:26 2025 +0100

    branch vazio para merge

D	atualizar_perfil.php
D	atualizar_perfil_bll.php
D	atualizar_perfil_dal.php
D	dashboard.php
D	dashboard_bll.php
D	dashboard_completo.php
D	login.php
D	login_bll.php
D	login_dal.php
D	styles.css
D	styles_atualizar_perfil.css
D	styles_dashboard.css

commit e493b58475d04df0ceb47067b52a6f2ed16e3dad	refs/remotes/origin/teste (origin/teste)
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 27 01:06:26 2025 +0100

    Adicionei funcionalidades de logout e páginas de
    acesso restrito, a partir da variavel de sessão
    "papel" que é definida no login. Ao dar logout,
    os cookies de sessão são eliminados de forma a
    que o utilizador não possa aceder às páginas
    restritas sem fazer login novamente.

M	BLL/Login_Utilizador_BLL.php
M	Equipas/equipas.php
M	Equipas/equipasElementos.php
M	atualizar.php
R087	4.php	dashboard.php
M	formacoes.php
M	index.php
M	login.php
A	logout.php
M	passReset.php
M	registar.php

commit 26f6878c2b98a303d3aeed337ae16d1287ebafd9	refs/remotes/origin/teste
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Thu Jun 26 22:52:09 2025 +0100

    Página de Criação de Equipas, Página de Alteração dos Elementos de uma Equipa, Organização do Código
    Ambas as novas páginas estão funcionais!

A	BLL/Equipas_BLL.php
A	BLL/Equipas_Elementos_BLL.php
A	BLL/Global_BLL.php
A	DAL/Equipas_DAL.php
A	DAL/Equipas_Elementos_DAL.php
A	DAL/Global_DAL.php
M	DAL/Login_Utilizador_DAL.php
A	Equipas/equipas.php
A	Equipas/equipasElementos.php
A	styles.css

commit 78e22b5a194aa4bac454c120c9f81cb3a52bcfd0	refs/remotes/origin/teste
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Wed Jun 25 22:36:51 2025 +0100

    testar novo branch 2

M	BLL/Registo_Utilizador_BLL.php
A	CSS/global.css
M	CSS/login.css
M	CSS/registar.css
M	DAL/Registo_Utilizador_DAL.php
M	JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js
M	JS/capsLockWarning.js
M	atualizar.php
M	index.php
M	login.php
M	registar.php

commit 56a9f4c73562d18748ce5cdfc9cebed65c57d29f	refs/remotes/origin/noya (origin/noya)
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Wed Jun 25 22:06:07 2025 +0100

    testar novo branch

R100	3.php	formacoes.php

commit a10b80857347331952c9c4981198cb2e8e56584a	refs/remotes/origin/noya
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Tue Jun 24 16:29:40 2025 +0100

    push

M	CSS/login.css
M	CSS/registar.css
</pre>

</details>

