# Commits by author
#### pedrodefreitasnoya@gmail.com
<details>
<summary>Diff</summary>

<pre>
 /CSS/login.css                   |  131 +++++++++++++++++++++
 /CSS/registar.css                |  117 +++++++++++++++++++
 /login.php                       |  206 +++++++++++++++++++++++++++++++++
 /registar.php                    |   72 +++++++++++
 Login_Utilizador_BLL.php         |    2 
 UserDAL.php                      |   20 ---
 b/3.php                          |  237 +++++++++++++++++++++++++++++++++++++++
 b/4.php                          |  195 ++++++++++++++++++++++++++++++++
 b/5.php                          |  129 +++++++++++++++++++++
 b/BLL/Login_Utilizador_BLL.php   |    3 
 b/BLL/Registo_Utilizador_BLL.php |    3 
 b/CSS/login.css                  |   10 +
 b/CSS/registar.css               |   10 +
 b/DAL/Login_Utilizador_DAL.php   |    3 
 b/DAL/Registo_Utilizador_DAL.php |    1 
 b/JS/capsLockWarning.js          |   39 ++++++
 b/Login_Utilizador_BLL.php       |   33 +++++
 b/Login_Utilizador_DAL.php       |   20 +++
 b/RegistoUtilizador_bll.php      |   35 +++++
 b/RegistoUtilizador_dal.php      |   39 ++++++
 b/UserDAL.php                    |   20 +++
 b/index.php                      |    1 
 b/login.php                      |    7 !
 b/registar.php                   |   14 +!
 b/register.php                   |  190 +++++++++++++++++++++++++++++++
 index.php                        |   20 +!!
 login.php                        |  134 ---------------------!
 register.php                     |  190 -------------------------------
 28 files changed, 1510 insertions(+), 342 deletions(-), 29 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 08842f636db9ea250bcc4f90be51aa8bc2b9caaa	refs/heads/master (HEAD -> master, origin/noya, origin/master, origin/HEAD)
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Fri Jun 20 10:53:29 2025 +0100

    FIX

R100	UserUpdate.php	BLL/Atualizar_Perfil_BLL.php
M	BLL/Login_Utilizador_BLL.php
M	BLL/Registo_Utilizador_BLL.php
M	CSS/login.css
M	CSS/registar.css
A	DAL/Atualizar_Perfil_DAL.php
M	DAL/Login_Utilizador_DAL.php
M	DAL/Registo_Utilizador_DAL.php
A	JS/capsLockWarning.js
A	atualizar.php
M	login.php
M	registar.php

commit 6e8b1bfa34f6ee85467d6b988fc3529ad147bbf8	refs/heads/master
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Thu Jun 19 18:19:48 2025 +0100

    organization

R092	Login_Utilizador_BLL.php	BLL/Login_Utilizador_BLL.php
R093	RegistoUtilizador_bll.php	BLL/Registo_Utilizador_BLL.php
A	CSS/login.css
A	CSS/registar.css
R100	Login_Utilizador_DAL.php	DAL/Login_Utilizador_DAL.php
R100	RegistoUtilizador_dal.php	DAL/Registo_Utilizador_DAL.php
M	index.php
M	login.php
A	registar.php
D	register.php

commit a8b955df91b4d596ab74ada34cdfcfeede53fe09	refs/heads/master
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Thu Jun 19 16:46:44 2025 +0100

    login and register system

A	3.php
A	4.php
A	5.php
A	Login_Utilizador_BLL.php
A	Login_Utilizador_DAL.php
A	RegistoUtilizador_bll.php
A	RegistoUtilizador_dal.php
D	UserBLL.php
D	UserDAL.php
M	index.php
A	login.php
A	register.php

commit 954dc38cc1e0af71ee0630cd14f3e65a91d912f1	refs/heads/master
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Wed Jun 18 12:03:49 2025 +0100

    template

R100	updateInfo.php	UserBLL.php
A	UserDAL.php
A	UserUpdate.php
M	index.php

commit 27645c0d7ddb4790049385adb8a5112223caebab	refs/remotes/origin/Noya (origin/Noya)
Author: Pedro Noya <pedrodefreitasnoya@gmail.com>
Date:   Wed Jun 18 11:11:26 2025 +0100

    inicio

M	index.php
A	updateInfo.php
</pre>

</details>

