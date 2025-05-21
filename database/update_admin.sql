-- Actualizar el rol del usuario admin
UPDATE users_login 
SET rol = 'admin' 
WHERE usuario = 'admin'; 