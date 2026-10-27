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
                <td colspan="2" style="text-align: center; padding: 40px 0;position: relative;overflow:hidden; background-image: url('{{ asset('build/admin/images/fundo.png') }}'); background-position: top center; background-repeat: no-repeat; background-size: cover;">
                    <img src="{{ asset('build/admin/images/whi-green-horizontal.png') }}" alt="WHI - Web de Alta Inovação" style="width: 210px; display: block; margin: 0 auto;">
                </td>
            </tr>

            <!-- Main Content -->
            <tr>
                <td colspan="2" style="padding: 35px;background-image: url('{{ asset('build/admin/images/bg-transparente.png') }}'); background-position: top center; background-repeat: no-repeat; background-size: cover;">
                    <h1 style="color: #10131C; font-size: 24px; margin: 0 0 20px; text-align: center;">Redefinição de Senha</h1>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Olá,</p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                        Você solicitou a redefinição de sua senha. Clique no link abaixo para redefini-la:
                    </p>
                    <p style="text-align: center; margin-bottom: 30px;">
                        <a href="{{ $url }}" style="background-color: #CBFF4D; color: #10131C; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                            Redefinir Senha
                        </a>
                    </p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                        Se você não solicitou esta alteração, nenhuma ação é necessária.
                    </p>
                    <p style="color: #555; font-size: 16px; line-height: 1.5;">Atenciosamente,<br><img src="{{ asset('build/admin/images/whi-black.png') }}" alt="WHI - Web de Alta Inovação" style="width: 50px"></p>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td colspan="2" style="background-image: url('{{ asset('build/admin/images/fundo.png') }}'); background-position: top center; background-repeat: no-repeat; background-size: cover; padding: 0;">
                    <!-- Linha superior colorida -->
                    <div style="width: 100%; height: 4px; background-color: #CBFF4D;"></div>

                    <!-- Logotipo centralizado -->
                    <div style="padding: 20px 0px; text-align: center;padding-bottom:10px;">
                        <img src="{{ asset('build/admin/images/whi-green-horizontal.png') }}" alt="WHI - Web de Alta Inovação" style="width: 210px; display: block; margin: 0 auto;">
                    </div>
                    
                    <div style="text-align: center;">
                        <a href="https://www.instagram.com/agenciawhi/?igsh=MXNkODZwOGp0MmFpbg%3D%3D#" target="_blank" style="font-weight: bold;color: #CBFF4D;font-size: 12px;text-decoration: none;display: inline-block;">
                            @agenciawhi
                        </a>
                    </div>
                    <!-- Rodapé com links e texto -->
                    <div style="padding: 0px 20px 10px 20px; font-family: Arial, sans-serif; color: #94a0ad; position:relative">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #94a0ad;">
                            <tr>
                                <td style="text-align: left; font-size:12px;">
                                    {{ date('Y') }} © WHI - Web de Alta Inovação
                                </td>
                                <td style="text-align: right;">
                                    <a href="https://www.whi.dev.br/" target="_blank" style="font-size:12px; color:#94a0ad; text-decoration: none; margin-left: 10px;">Sobre a WHI</a>
                                    <a href="https://wa.me/5571996483853" target="_blank" style="font-size:12px; color:#94a0ad; text-decoration: none; margin-left: 10px;">Fale conosco</a>
                                </td>
                            </tr>
                        </table>                        
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
