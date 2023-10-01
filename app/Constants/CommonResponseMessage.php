<?php

namespace App\Constants;

class CommonResponseMessage {
	// TO DO: refactor to use local translation files

	// CRUD messages
	public const INDEX_SUCCESS = '一覧の取得に成功しました。';
	public const DETAIL_SUCCESS = '詳細の取得に成功しました。';
	public const CREATE_SUCCESS = '登録に成功しました。';
	public const UPDATE_SUCCESS = '更新に成功しました。';
	public const DELETE_SUCCESS = '削除に成功しました。';
	public const INDEX_FAILED = '一覧の取得に失敗しました。';
	public const DETAIL_FAILED = '詳細の取得に失敗しました。';
	public const CREATE_FAILED = '登録に失敗しました。';
	public const UPDATE_FAILED = '更新に失敗しました。';
	public const DELETE_FAILED = '削除に失敗しました。';
	// HTTP messages
	public const NOT_FOUND = 'データが見つかりませんでした。';
	public const VALIDATION_ERROR = '入力内容に誤りがあります。';
	public const BAD_RELATIONSHIP = '関連付けが不正です。';
	public const UNAUTHORIZED = '認証に失敗しました。';
	public const FORBIDDEN = 'アクセス権限がありません。';
	public const INTERNAL_SERVER_ERROR = 'サーバー内部でエラーが発生しました。';
	public const BAD_REQUEST = 'リクエストが不正です。';
	public const UNPROCESSABLE_ENTITY = 'リクエストを処理できませんでした。';
	public const METHOD_NOT_ALLOWED = '許可されていないメソッドです。';
	public const TOO_MANY_REQUESTS = 'リクエストが多すぎます。';
	public const SERVICE_UNAVAILABLE = 'サービスが利用できません。';
	public const GATEWAY_TIMEOUT = 'タイムアウトしました。';
	public const NOT_IMPLEMENTED = '実装されていません。';
	public const BAD_GATEWAY = '不正なゲートウェイです。';
	public const UNEXPECTED_ERROR = '予期せぬエラーが発生しました。';
	public const INVALIDE_SIGNATURE = 'URLが誤っているか、期限切れです。';
	// File upload messages
	public const FILE_UPLOAD_FAILED = 'ファイルのアップロードに失敗しました。';
	public const FILE_DELETE_FAILED = 'ファイルの削除に失敗しました。';
	// Auth messages
	public const REGISTER_VERIFICATION_SUCCESS = '登録に成功しました。メールを確認の上、本人確認を完了してください。';
	public const LOGIN_SUCCESS = 'ログインに成功しました。';
	public const LOGIN_FAILED = 'メールアドレスかパスワードに誤りがあります。';
	public const PASSWORD_INCORRECT = 'パスワードに誤りがあります。';
	public const LOGOUT_SUCCESS = 'ログアウトに成功しました。';
	public const UNVERIFIED_USER = '本人確認が完了していません。メールを確認の上、本人確認を完了してください。';
	public const VERIFIED_SUCCESS = '本人確認に成功しました。';
	public const VERIFICATION_SEND = '本人確認メールを送信しました。';
	public const VERIFICATION_RESEND = '本人確認メールを再送信しました。';
	public const ALREADY_VERIFIED = '既に本人確認が完了しています。';
	public const VERIFIED_USER_NOT_EXIST = '本人確認対象のユーザーが存在しません。';
	public const EMAIL_NOT_EXIST = 'メールアドレスが存在しません。';
	public const EMAIL_ALREADY_EXIST = 'メールアドレスは既に登録されています。';
	public const USER_ALREADY_DELETED = 'このユーザーは退会済みです。';
	public const NOT_EXIST_AUTHENTICATED_USER = '認証済みのユーザーが存在しません。';
	public const USER_NOT_EXIST = 'ユーザーが存在しません。';
	// Passowrd reset messages
	public const PASSWORD_RESET_SEND = 'パスワードリセットメールを送信しました。';
	public const PASSWORD_RESET_SUCCESS = 'パスワードをリセットしました。';
	public const INVALID_TOKEN = 'トークンが不正です。';
}