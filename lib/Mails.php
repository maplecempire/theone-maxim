<?php


abstract class Mails {
    /*******************************/
    /*****    Email  ******/
    /*******************************/
    const EMAIL_SMTP = true;
    const EMAIL_SMTP_SECURE = "tls";
    const EMAIL_PORT = 587;
    const EMAIL_HOST = "smtp.live.com";

//    const EMAIL_FROM = "admin@maximtrader.com";
//    const EMAIL_FROM_NOREPLY = "admin@maximtrader.com";
//    const EMAIL_SENDER = "admin@maximtrader.com";
//    const EMAIL_PASSWORD = "qwer1234";

//    const EMAIL_FROM = "support@maximtrader.com";
//    const EMAIL_FROM_NOREPLY = "support@maximtrader.com";
//    const EMAIL_SENDER = "support@maximtrader.com";
//    const EMAIL_PASSWORD = "maximtemp";

//    const EMAIL_FROM = "account@maximtrader.com";
//    const EMAIL_FROM_NOREPLY = "account@maximtrader.com";
//    const EMAIL_SENDER = "account@maximtrader.com";
//    const EMAIL_PASSWORD = "Q!W@E#123";

    const EMAIL_FROM = "noreply@maximtrader.com";
    const EMAIL_FROM_NOREPLY = "noreply@maximtrader.com";
    const EMAIL_SENDER = "noreply@maximtrader.com";
    const EMAIL_PASSWORD = "Q!W@E#123";

    const CS_EMAIL_FROM = "no_reply@maximtrader.com";
    const CS_EMAIL_FROM_NOREPLY = "no_reply@maximtrader.com";
    const CS_EMAIL_SENDER = "no_reply@maximtrader.com";
    const CS_EMAIL_PASSWORD = "pass!@#$";

    const EMAIL_FROM_NAME = "Maxim Trader";
    const EMAIL_FROM_NOREPLY_NAME = "Maxim Trader";
    const EMAIL_SENDER_INFO = "noreply@maximtrader.com";
    const EMAIL_TEST_MAIL = "r9projecthost@gmail.com";
    const EMAIL_BCC = "r9projecthost@gmail.com";
    const EMAIL_BCC_NAME = "r9projecthost";
}