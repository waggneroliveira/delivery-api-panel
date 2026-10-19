<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table class="wrapper" width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color: #fff; margin: 20px auto; border-radius: 8px; overflow: hidden;">
        <tbody>
            <!-- Header -->
            <tr>
                <td colspan="2" style="background: #2F368B; text-align: center; padding: 40px 0;">
                    <img src="{{secure_asset('build/client/images/logo.png')}}" alt="sindacs-BA" style="width: 185px; display: block; margin: 0 auto;">
                </td>
            </tr>

            <!-- Main Content -->
            <tr>
                <td colspan="2" style="padding: 40px 63px;">
                    <h1 style="color: #333; font-size: 24px; margin: 0 0 20px; text-align: center;">Redefinição de Senha</h1>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Olá,</p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                        Você solicitou a redefinição de sua senha. Clique no link abaixo para redefini-la:
                    </p>
                    <p style="text-align: center; margin-bottom: 30px;">
                        <a href="{{ $url }}" style="background-color: #E5282A; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                            Redefinir Senha
                        </a>
                    </p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                        Se você não solicitou esta alteração, nenhuma ação é necessária.
                    </p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5;">Atenciosamente,<br>SINDACS-BA</p>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td colspan="2" style="background: #f3f3f3; padding: 0;">
                    <div style="width: 100%; height: 4px; background-color: #E5282A;"></div>
                    <div style="background: #2F368B; padding: 28px 40px; text-align: center;">
                        <img src="{{secure_asset('build/client/images/logo.png'))}}" alt="sindacs-BA" style="width: 107px; margin: 0 auto;">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
