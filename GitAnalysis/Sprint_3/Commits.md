# Commits by author
#### 1222066@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /perfil.php                          |   15 
 /perfil_bll.php                      |  520 +++++++++++++++++++++++
 /perfil_dal.php                      |  324 ++++++++++++++
 BLL/Equipas_Elementos_BLL.php        |    6 
 BLL/InformacoesColaborador_bll.php   |  777 ++++++++++---------------------!!
 BLL/Listar_Trabalhadores_BLL.php     |    2 
 BLL/atualizar_perfil_bll.php         |  364 +++++++++-----
 DAL/Equipas_Elementos_DAL.php        |   11 
 DAL/InformacoesColaborador_dal.php   |   49 +!
 DAL/atualizar_perfil_dal.php         |   18 
 InformacoesColaborador.php           |    2 
 atualizar_perfil.php                 |    3 
 b/BLL/Equipas_Elementos_BLL.php      |    1 
 b/BLL/InformacoesColaborador_bll.php |    5 
 b/BLL/Listar_Trabalhadores_BLL.php   |    3 
 b/BLL/atualizar_perfil_bll.php       |  131 ++++!
 b/BLL/cabecalho_bll.php              |   36 +
 b/CSS/atualizar_perfil.css           |    4 
 b/DAL/Equipas_Elementos_DAL.php      |    2 
 b/DAL/InformacoesColaborador_dal.php |   20 
 b/DAL/Listar_Trabalhadores_DAL.php   |   37 +
 b/DAL/atualizar_perfil_dal.php       |    8 
 b/DAL/cabecalho_dal.php              |   19 
 b/InformacoesColaborador.php         |    8 
 b/JS/listar_trabalhadores.js         |    1 
 b/api.php                            |  102 ++++
 b/atualizar_perfil.php               |    1 
 b/cabecalho.php                      |    8 
 b/dashboard.php                      |    7 
 b/dashboard_bll.php                  |    2 
 b/dashboard_dal.php                  |    2 
 b/dashboard_teste.php                |  219 +++++++++
 b/dashboard_teste_bll.php            |   69 +++
 b/dashboard_teste_dal.php            |   62 ++
 b/index.php                          |    1 
 b/listar_trabalhadores.php           |    4 
 b/login.php                          |    2 
 b/perfil.php                         |    2 
 b/perfil_bll.php                     |    9 
 b/perfil_dal.php                     |   43 +
 b/registar.php                       |    1 
 b/styles_atualizar_perfil.css        |   24 +
 dashboard.php                        |   29 !
 dashboard_bll.php                    |   99 +++
 dashboard_dal.php                    |   60 ++
 perfil_bll.php                       |  112 ++!!
 perfil_dal.php                       |   70 ++!
 47 files changed, 2351 insertions(+), 627 deletions(-), 316 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 6135c136203618836840292940c0d3297f480815	refs/heads/master (HEAD -> master, tag: v1.0, origin/master, origin/Tiago, origin/HEAD)
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 22:02:47 2025 +0100

    Dashboard atualizada

M	dashboard.php
M	dashboard_bll.php

commit 3547090f3e95f772dcedc912053063073db5f23f	refs/heads/master
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 22:00:10 2025 +0100

    Equipas Elementos terminada por agora

M	BLL/Equipas_Elementos_BLL.php
M	DAL/Equipas_Elementos_DAL.php

commit d3a1a7ff4c713b42bd69c17665c186414e9172e0	refs/heads/master
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 21:53:03 2025 +0100

    Equipas

M	DAL/Equipas_Elementos_DAL.php

commit 70a113d76a273880a03d4e6047759c4d8d8002a7	refs/heads/master
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 21:49:48 2025 +0100

    Equipas Elementos

M	BLL/Equipas_Elementos_BLL.php
M	DAL/Equipas_Elementos_DAL.php

commit e3ab0ce72a85b094b1d075554ab170cf32a615ea	refs/heads/master
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 21:48:19 2025 +0100

    Equipas Elementos alteração

M	BLL/Equipas_Elementos_BLL.php

commit 5e48c1f7b32b74d7c41127088bee36ef06e605e7	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 12:40:50 2025 +0100

    Alterações às páginas de listar colaboradores

M	BLL/Listar_Trabalhadores_BLL.php
M	DAL/Listar_Trabalhadores_DAL.php
M	listar_trabalhadores.php

commit e56cd7119b9dd07239496d446da40b29cce3169e	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 11:52:16 2025 +0100

    Página perfil concluída

A	BLL/cabecalho_bll.php
A	DAL/cabecalho_dal.php
M	cabecalho.php
M	perfil_bll.php

commit c19dab2e5e2144a8e4ec9289c8473517ce9d15af	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sun Jul 6 10:59:59 2025 +0100

    Página perfil concluída

M	login.php
M	perfil.php
M	perfil_bll.php
M	perfil_dal.php

commit 9d1846e72ce1d01c1292cb93a741179802e79970	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jul 5 23:02:55 2025 +0100

    Mais alterações

M	BLL/InformacoesColaborador_bll.php

commit 0a18a21be0d1d21880ebadea18ebaf7b8ad67a56	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jul 5 22:57:49 2025 +0100

    Mais alterações

M	BLL/InformacoesColaborador_bll.php
M	CSS/atualizar_perfil.css
M	InformacoesColaborador.php

commit 09bd9076c151be72d09c19f3243ba81ea67c0a97	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jul 5 21:30:54 2025 +0100

    Página "InformacoesColaborador" concluída!

M	BLL/InformacoesColaborador_bll.php
M	DAL/InformacoesColaborador_dal.php

commit 8a3d4abea898efd94c01a2cb22fcd347a319c5d7	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jul 5 16:11:20 2025 +0100

    Página de Informações do Colaboradr já tem o voucher NOS a funcionar perfeitamente

M	BLL/InformacoesColaborador_bll.php
M	DAL/InformacoesColaborador_dal.php
M	perfil_dal.php

commit d69ae5cff6a06adca55c39746a12b1a1f7fc9b81	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Sat Jul 5 00:06:13 2025 +0100

    Parte dos Vouchers feita para uma parte da página de perfil.

M	perfil_bll.php
M	perfil_dal.php

commit 0b4ef59ab065815029766adbad0a392786a7e847	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jul 4 19:22:12 2025 +0100

    Página de perfil permite atualização da password

M	perfil_bll.php
M	perfil_dal.php

commit 99a184167780e7045ccd5292bc546945aed1730f	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jul 4 17:48:00 2025 +0100

    Página de informações do colaborador

M	BLL/InformacoesColaborador_bll.php
M	BLL/Listar_Trabalhadores_BLL.php
M	DAL/InformacoesColaborador_dal.php
M	InformacoesColaborador.php
M	JS/listar_trabalhadores.js

commit 528270ed8e37e3fb1b00d318b1279deb82f31eb0	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jul 4 10:56:39 2025 +0100

    Adição de uma página de dashboard de teste

A	dashboard_teste.php
A	dashboard_teste_bll.php
A	dashboard_teste_dal.php

commit 2b207f6684c55176ec9898e2d29fbd69bcbcd300	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jul 4 10:20:29 2025 +0100

    Perfil "Concluído"

M	index.php
M	perfil_bll.php
M	perfil_dal.php

commit 506ed75965c23f7ffbf3e73c31966a1c9701402c	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Fri Jul 4 10:04:41 2025 +0100

    Mais alterações

M	dashboard.php
M	dashboard_bll.php
M	perfil_bll.php
M	perfil_dal.php

commit c0c1adb90810dea4514bf607ce40d280f861c29a	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 23:41:01 2025 +0100

    Página Informações Colaborador "feita" (faltam testes serem feitos)

M	BLL/InformacoesColaborador_bll.php

commit fae2f54a0d5e8c8b59681e75db973eafd63640c2	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 20:08:17 2025 +0100

    Alteração do nome da página "atualizar_perfil" para "InformacoesColaborador"

R099	BLL/atualizar_perfil_bll.php	BLL/InformacoesColaborador_bll.php
R100	DAL/atualizar_perfil_dal.php	DAL/InformacoesColaborador_dal.php
R084	atualizar_perfil.php	InformacoesColaborador.php

commit 2812c128d41c819a6d8191e8fbd1fc5511eb3ad8	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 19:02:26 2025 +0100

    Adição de estilos ao campo para inserir ficheiros (o campo em si não faz nada)

M	perfil_bll.php
M	styles_atualizar_perfil.css

commit 7409a570e2932554f6a8dc18a074adca83440746	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:51:40 2025 +0100

    Página de Perfil "concluída"

M	perfil_dal.php

commit 2402cf585ae291233164d6a37a1236d68a8962fc	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:47:41 2025 +0100

    Aperfeiçoamento da página de perfil

M	perfil_bll.php
M	perfil_dal.php

commit d59d4c38003a8676ca28bd39269016d1de326135	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:27:54 2025 +0100

    Página perfil quase concluída

M	perfil_bll.php

commit 3534cbde03f0721a536325dd99bd821fc752ae9f	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:26:53 2025 +0100

    Erro corrigido

M	atualizar_perfil.php

commit 2c6bc06b31514c03cb11f2d6c5855e3c5a15002a	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:25:23 2025 +0100

    Mais

M	atualizar_perfil.php

commit 231a6b7fec2ac3fd9f9da08b710c1b7b83245cd5	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:21:59 2025 +0100

    Modificações na página de perfil

M	perfil_bll.php
M	perfil_dal.php

commit de11af14d023b599b69412bb6f8b862c759d5346	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 18:19:56 2025 +0100

    Página de Perfil criada

A	perfil.php
A	perfil_bll.php
A	perfil_dal.php

commit d0c046335c4686e8674af46760bfaf13e1b95ac6	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 14:25:03 2025 +0100

    Só a conclusão da página php atualizar perfil

M	atualizar_perfil.php

commit ccc134290452912a8948bd43b3d998eadf1a426b	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Thu Jul 3 14:23:03 2025 +0100

    Página atualizar perfil atualizada

M	BLL/atualizar_perfil_bll.php

commit deb9ceb2b3ccf0d4783c19b7545e02b4db6db2b9	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jul 2 18:57:08 2025 +0100

    Alterações na página de atualizar perfil

M	BLL/atualizar_perfil_bll.php
M	DAL/atualizar_perfil_dal.php

commit 45b14e22f36c08b00374b45e11b058b632bc7dc3	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jul 2 13:00:17 2025 +0100

    Mais alterações

M	dashboard_bll.php

commit a60d9e995df4c1bb8e281f4f664032d9fe2599eb	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jul 2 12:29:25 2025 +0100

    Mais um gráfico criado (Distribuição por Nacionalidade)

M	dashboard.php
M	dashboard_bll.php
M	dashboard_dal.php

commit 58b3871e0d91c7384b9ac4b84b3b3ef36cb85be6	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jul 2 12:15:10 2025 +0100

    Página da dashboard já considera os dados mostrados dependendo do tipo de colaborador que acede à página.

M	dashboard_bll.php
M	dashboard_dal.php
M	registar.php

commit c6224b27586ec5314b7b67b6ab55b1f109370d3a	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Wed Jul 2 08:58:39 2025 +0100

    Criação da página api.php

M	BLL/atualizar_perfil_bll.php
A	api.php

commit 51173b328f46786ff3fdc211205347122cd4902b	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Mon Jun 30 17:23:58 2025 +0100

    Alterações à página atualizar_perfil

M	BLL/atualizar_perfil_bll.php
M	DAL/atualizar_perfil_dal.php

commit d2cada94fdfaabd7a1d98eb4fdb65bd63a2b2dfa	refs/remotes/origin/Noya
Author: Tiago Almeida <1222066@isep.ipp.pt>
Date:   Mon Jun 30 16:18:50 2025 +0100

    Ult altera

M	BLL/atualizar_perfil_bll.php
</pre>

</details>

#### 1231113@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 0 files changed
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
</pre>

</details>

#### pedrodefreitasnoya@gmail.com
<details>
<summary>Diff</summary>

<pre>
 /API/eliminar_alerta.php             |   20 ++++++
 /BLL/Alertas_BLL.php                 |   25 ++++++++
 /DAL/Alertas_DAL.php                 |   33 ++++++++++
 /JS/alertas.js                       |   60 +++++++++++++++++++
 /alertas.php                         |  104 +++++++++++++++++++++++++++++++++
 /cabecalho.php                       |   19 ++++++
 /emitir_alertas.php                  |   65 ++++++++++++++++++++
 BLL/Alertas_BLL.php                  |   12 +++
 BLL/Global_BLL.php                   |   80 +++++++++++++++++++++++++
 BLL/InformacoesColaborador_bll.php   |    2 
 DAL/Alertas_DAL.php                  |   32 ++++++++++
 Equipas/equipas.php                  |   20 -----!
 Equipas/equipasElementos.php         |   19 -----!
 alertas.php                          |   28 +++++!!!
 atualizar.php                        |   87 ---------------------------
 atualizar_perfil.php                 |    1 
 b/API/descartar_alerta.php           |   24 +++++++
 b/API/eliminar_alerta.php            |    2 
 b/API/enviar_alerta.php              |   32 ++++++++++
 b/API/obter_alerta.php               |   29 +++++++++
 b/BLL/Alertas_BLL.php                |    5 +
 b/BLL/Equipas_BLL.php                |   12 +++
 b/BLL/Global_BLL.php                 |    6 !
 b/BLL/InformacoesColaborador_bll.php |    6 !
 b/BLL/Listar_Trabalhadores_BLL.php   |    1 
 b/BLL/Login_Utilizador_BLL.php       |    1 
 b/BLL/Registo_Utilizador_BLL.php     |   44 -------------!
 b/BLL/atualizar_perfil_bll.php       |    1 
 b/BLL/cabecalho_bll.php              |   22 +!!!!!!
 b/CSS/alertas.css                    |   43 +++++++++++++
 b/CSS/global.css                     |    9 ++
 b/DAL/Alertas_DAL.php                |   10 +++
 b/DAL/Equipas_DAL.php                |    9 ++
 b/DAL/Global_DAL.php                 |   26 ++++++++
 b/DAL/Listar_Trabalhadores_DAL.php   |    1 
 b/Equipas/equipas.php                |    1 
 b/Equipas/equipasElementos.php       |    1 
 b/Equipas/equipasInfo.php            |   39 ++++++++++++
 b/JS/alertas.js                      |  103 ++++++++++++++++++++++++++++++!!!
 b/JS/emitir_alertas.js               |  109 +++++++++++++++++++++++++++++++++++
 b/JS/equipas_info.js                 |   12 +++
 b/alertas.php                        |   50 +!!!!!!!!!!!!!!!
 b/api.php                            |    3 
 b/atualizar.php                      |   20 -----!
 b/atualizar_perfil.php               |    2 
 b/cabecalho.php                      |    1 
 b/dashboard.php                      |   12 !!!
 b/dashboard_bll.php                  |    1 
 b/definir_nivel.php                  |    1 
 b/emitir_alertas.php                 |   66 +++++++++++++++!!!!!!
 b/index.php                          |    2 
 b/listar_trabalhadores.php           |    1 
 b/login.php                          |    1 
 b/passReset.php                      |   14 ----
 b/registar.php                       |    9 +-
 cabecalho.php                        |   17 !!!!!
 dashboard.php                        |   38 ----!!!!!!!!
 index.php                            |    1 
 listar_trabalhadores.php             |   17 -----
 login.php                            |   26 -------
 registar.php                         |   20 -----!
 61 files changed, 990 insertions(+), 274 deletions(-), 193 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit dd85575c2642e08449e07795e0456cf9c129f529	refs/remotes/origin/Noya (origin/Noya)
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jul 6 21:32:15 2025 +0100

    Fix de bugs, pequeno commit

M	BLL/InformacoesColaborador_bll.php
M	BLL/Listar_Trabalhadores_BLL.php
M	BLL/Login_Utilizador_BLL.php
M	BLL/cabecalho_bll.php
M	DAL/Listar_Trabalhadores_DAL.php
M	dashboard.php
M	dashboard_bll.php
M	login.php

commit ff486d5b64f7bdde8e2ad7b4e82cc7b494753c9b	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sun Jul 6 20:27:38 2025 +0100

    Páginas de alertas melhoradas

M	BLL/Equipas_BLL.php
M	CSS/global.css
M	DAL/Equipas_DAL.php
M	DAL/Global_DAL.php
M	Equipas/equipas.php
M	Equipas/equipasElementos.php
A	Equipas/equipasInfo.php
A	JS/equipas_info.js
M	alertas.php
M	cabecalho.php
M	emitir_alertas.php
M	index.php
M	listar_trabalhadores.php
M	login.php
M	registar.php

commit 79b671abec9e8df48a95ac1d40b06d3f86ee93e9	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sat Jul 5 19:19:13 2025 +0100

    Pagina de enviar alertas por parte do RH.
    esta pagina permite:
    - Enviar alertas para os colaboradores
    - Descartar alertas
    
    paginas de auxilio (API):
    - API/descartar_alerta.php
    - API/enviar.php
    
    Tambem modifiquei a criação de equipas para que
    a data de criação seja selecionada pelo RH.

A	API/descartar_alerta.php
M	API/eliminar_alerta.php
A	API/enviar_alerta.php
M	BLL/Alertas_BLL.php
M	BLL/Global_BLL.php
M	DAL/Alertas_DAL.php
M	Equipas/equipas.php
A	JS/emitir_alertas.js
M	alertas.php
A	emitir_alertas.php

commit 7bf998abf5aeb1cc2b6727382a8f78dee44051e7	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Sat Jul 5 13:45:09 2025 +0100

    Pagina de alertas funcional com a base de dados,
    adicionando, editando e eliminando alertas.
    
    paginas API para obter e eliminar alertas.
    (Aprendisagem de conceito de Asincronismo com JavaScript
    no contexto do metodo fetch e async/await)

A	API/eliminar_alerta.php
A	API/obter_alerta.php
M	BLL/Alertas_BLL.php
M	BLL/Global_BLL.php
M	BLL/InformacoesColaborador_bll.php
M	DAL/Alertas_DAL.php
M	JS/alertas.js
M	alertas.php
M	api.php
D	atualizar.php
M	definir_nivel.php

commit f261f29d00c333ba3f7a3578877a9280acf11dca	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jul 4 08:20:17 2025 +0100

    ver e editar alertas existentes

A	BLL/Alertas_BLL.php
M	BLL/Global_BLL.php
M	BLL/Registo_Utilizador_BLL.php
M	BLL/atualizar_perfil_bll.php
A	CSS/alertas.css
R100	styles_atualizar_perfil.css	CSS/atualizar_perfil.css
A	DAL/Alertas_DAL.php
A	JS/alertas.js
A	alertas.php
M	atualizar_perfil.php
M	cabecalho.php
M	login.php
M	registar.php

commit f1c1e8bb04fa678a240ab28e1c9e7147d4b2f35d	refs/remotes/origin/Noya
Author: Pedro-Noya <pedrodefreitasnoya@gmail.com>
Date:   Mon Jun 30 16:54:41 2025 +0100

    cabeçalho externo para organização

M	Equipas/equipas.php
M	Equipas/equipasElementos.php
M	atualizar.php
M	atualizar_perfil.php
A	cabecalho.php
M	dashboard.php
M	index.php
M	listar_trabalhadores.php
M	login.php
M	passReset.php
M	registar.php
</pre>

</details>

