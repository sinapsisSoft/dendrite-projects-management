SELECT USER.User_id, USER.User_name,COMP.Comp_id, COMP.Comp_name, ROL.Role_id, ROL.Role_name,ROL_MOD.Mod_id, MODU.Mod_name,MODU.Mod_route, PER.Perm_id FROM user USER 
INNER JOIN company COMP ON USER.Comp_id=COMP.Comp_id
INNER JOIN role ROL ON USER.Role_id=ROL.Role_id
INNER JOIN role_module ROL_MOD ON ROL.Role_id=ROL_MOD.Role_id
INNER JOIN module MODU ON MODU.Mod_id=ROL_MOD.Mod_id
INNER JOIN role_module_permit ROLE_PER ON ROLE_PER.Role_mod_id=ROL_MOD.Role_mod_id
INNER JOIN permit PER ON PER.Perm_id=ROLE_PER.Perm_id
WHERE USER.User_id='2';


SELECT USER.User_id, USER.Stat_id FROM user USER 
INNER JOIN company COM ON COM.Comp_id=USER.Comp_id 
WHERE User_password='Sinapsis2023*' AND User_email='d.casallas@sinapsist.com.co' AND COM.Stat_id=2 AND USER.Stat_id=2;


