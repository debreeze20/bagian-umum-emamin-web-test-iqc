<style>
    body {
        font-family: Arial !important;
        background: #F3F6F9 !important;
        padding: 30px;
    }

</style>
<div style="background:#fff;width:100%;max-width:400px;padding:20px;display:block;margin:auto;">
    <img alt="Logo" src="{{asset('assets/extends/images/icon-hallo.png')}}"
        style="width:230px;display:block;margin:auto;" />
    <div style="text-align:center;font-weight:600;font-size:24px;color:black;">Hey {{$name}}, Verifikasi Email Anda!</div>
    <div style="color:#5E6278;text-align:center;padding-top:15px;">Terima kasih sudah mendaftar, silahkan memverifikasi email akun anda terlebih dahulu sebelum data anda diverifikasi oleh admin.</div>
    @if ($is_created_by_admin == true)
        <div style="color:#5E6278;text-align:center;padding-top:15px;">Berikut password akunmu: {{config('myconfig.default_password')}}</div>
    @endif
    <div style="margin-bottom:40px;text-align:center;margin-top:40px;">
        <a href="{{$actionUrl}}"
            style="background:#F8D831;color:black;padding:15px 20px;border-radius:10px;text-decoration:none !important;font-weight:500;">
            Verifikasi Email
        </a>
    </div>
    <div style="text-align:center;margin-top:50px;margin-bottom:15px;color:black">© {{\Carbon\Carbon::now()->format('Y')}} - Copyright Disbudporapar Kota Surabaya. All right reserved</div>
</div>
