@component('mail::message')
<center role="article" aria-roledescription="email" lang="en" style="width: 100%; background-color: #ffffff;">
    <!--[if mso | IE]>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" id="body_table" style="background-color: #ffffff;">
            <tbody>
                <tr>
                    <td>
                      <![endif]-->
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
        style="margin: auto;" class="contentMainTable">
        <tr class="wp-block-editor-imageblock-v1">
            <td style="background-color:#fff;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"
                align="center">
                <table align="center" width="300" class="imageBlockWrapper" style="width:560px" role="presentation">
                    <tbody>
                        <tr>
                            <td style="padding:0;">
                                <img src="https://api.smtprelay.co/userfile/e47fe6a6-3957-4ffb-b8e9-375e838280c7/logo.png"
                                    height="" alt=""
                                    style="border-radius:0px;display:block;height:auto;width:50%;max-width:100%;border:0;margin:auto"
                                    class="g-img">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="wp-block-editor-imageblock-v1">
            <td style="background-color:#fff;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"
                align="center">
                <table align="center" width="300" class="imageBlockWrapper" style="width:560px" role="presentation">
                    <tbody>
                        <tr>
                            <td style="padding:0;">
                                <img src="https://api.smtprelay.co/userfile/e47fe6a6-3957-4ffb-b8e9-375e838280c7/viajeros.JPG"
                                    height="" alt=""
                                    style="border-radius:0px;display:block;height:auto;width:50%;max-width:100%;border:0;margin:auto"
                                    class="g-img">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="wp-block-editor-headingblock-v1">
            <td valign="top"
                style="background-color:#fff;display:block;padding-top:50px;padding-right:20px;padding-bottom:20px;padding-left:20px;text-align:center">
                <p style="font-family:Open Sans, sans-serif;text-align:center;line-height:36.80px;font-size:32px;background-color:#fff;color:#444444;margin:0;word-break:normal"
                    class="heading1">Hola {{ $name }}</p>
            </td>
        </tr>
        <tr class="wp-block-editor-paragraphblock-v1">
            <td valign="top" style="padding:20px 20px 20px 20px;background-color:#fff">
                <p class="paragraph"
                    style="font-family:Open Sans, sans-serif;text-align:center;line-height:18.40px;font-size:16px;margin:0;color:#5f5f5f;word-break:normal">
                    Ya sea como conductor o pasajero, tienes a tu alcance una mejor forma de viajar: más económica,
                    sostenible y divertida.
                </p>
                <br>
                <p>
                    ¡Te damos la bienvenida a Drivo! ¿Puedes confirmar tu email?
                </p>
            </td>
        </tr>
        <tr class="wp-block-editor-buttonblock-v1" align="center">
            <td style="background-color:#fff;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;width:100%"
                valign="top">
                <table role="presentation" cellspacing="0" cellpadding="0" class="button-table">
                    <tbody>
                        <tr>
                            <td valign="top" class="button-td button-td-primary"
                                style="cursor:pointer;border:none;border-radius:4px;background-color:#3DBD61;font-size:16px;font-family:Open Sans, sans-serif;width:fit-content;color:#ffffff">
                                <a style="color:#ffffff" href="{consent}">
                                    <table role="presentation">
                                        <tbody>
                                            <tr>
                                                <!-- Top padding -->
                                                <td valign="top" colspan="3" height="12"
                                                    style="height: 12px; line-height: 1px; padding: 0;">
                                                    <span style="display: inline-block;">&nbsp;</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- Left padding -->
                                                <td valign="top" width="16"
                                                    style="width: 16px; line-height: 1px; padding: 0;">
                                                    <span style="display: inline-block;">&nbsp;</span>
                                                </td>
                                                <!-- Content -->
                                                <td valign="top"> <a style="
                            display: inline-block;
                            cursor: pointer; border: none; border-radius: 4px; background-color: #3DBD61; font-size: 16; font-family: Open Sans, sans-serif; width: fit-content; font-weight: null; letter-spacing: undefined;
                              color: #ffffff;
                              padding: 0;
                              " href="http://viajes.com/verify/{{ $id }}">Confirma tu email</a> </td>
                                                <!-- Right padding -->
                                                <td valign="top" width="16"
                                                    style="width: 16px; line-height: 1px; padding: 0;">
                                                    <span style="display: inline-block;">&nbsp;</span>
                                                </td>
                                            </tr>
                                            <!-- Bottom padding -->
                                            <tr>
                                                <td valign="top" colspan="3" height="12"
                                                    style="height: 12px; line-height: 1px; padding: 0;">
                                                    <span style="display: inline-block;">&nbsp;</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top" align="center" style="padding:20px 20px 20px 20px;background-color:#fff">
                <p aria-label="Unsubscribe" class="paragraph"
                    style="font-family:Open Sans, sans-serif;text-align:center;line-height:13.80px;font-size:12px;margin:0;color:#5f5f5f;word-break:normal">
                    Equipo Drivo</p>
            </td>
        </tr>
    </table>
    <!--[if mso | IE]>
</td>
</tr>
</tbody>
</table>
<![endif]-->
    <em style="font-size: 6pt"></em>
</center>
@endcomponent