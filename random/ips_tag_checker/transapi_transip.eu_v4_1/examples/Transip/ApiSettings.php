<?php

/**
 * This class holds the settings for the TransIP API.
 */
class Transip_ApiSettings
{
	/**
	 * The mode in which the API operates, can be either:
	 *		readonly
	 *		readwrite
	 *
	 * In readonly mode, no modifying functions can be called.
	 * To make persistent changes, readwrite mode should be enabled.
	 */
	public static $mode = 'readonly';

	 /**
	 * TransIP API endpoint to connect to.
	 *
	 * e.g.:
	 *
	 * 		'api.transip.nl'
	 * 		'api.transip.be'
	 * 		'api.transip.eu'
	 */
	public static $endpoint = 'api.transip.eu';

	/**
	 * Your login name on the TransIP website.
	 *
	 */
	public static $login = 'mbcx9rvt';

	/**
	 * One of your private keys; these can be requested via your Controlpanel
	 */
	public static $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEA52IIrZpn7BpOc/oVPW4fNzn8Udx7ezGZDZLnHiDUokoK7pX0
kjW7PiBn6wh4Y6HsCdIohcwA4D1hhjnxNq9w4zZT2mcbdrHDDsGXmwj5T1EfleCk
qy4M18Kt/hX4jAaxSZGXA3flkXYaR8/WRLQK7kpzWuwYzL6iVcpTle2/xXcE1gTs
DDAVgFYH1HXfMi4bvLJ3q25PR2wYfNtsNv2yDNxN2zE1lUnolc2lcLa9jAGCss+E
XAbOXxy0TG9EKYKJg7BTpxmxX6pBPDckPdHunHt/ILfchunMahcnhz2GeCiUDEle
B7yf8yIjhVZBTVg742gkpjod2lysNTVeHj/g2wIDAQABAoIBAGbACxiEu+eGGxa3
lJ0N/QC6WElF/vPLJ6t2c/nWHHbhKI+gudX/1GGXZG5j+YpNCpOl5ubbm/v4ZgmE
S5C8QgY0RvJy3ShNclBoOdnYF1ZYsQ0OkDGQJpXd1wRBX3lXM313ELeyk5iP+MWx
Dva9eSkumKFkvPKXKWGtkoa+6G1YP9wKKmyecvVazs/Ta/B09P7RaaWBkUK7ZG2c
0FlfmZg5wBDwx9EJ0pIs0fjow955tKABNIdUT1Zgm+HgiCcBILp32rR5OgUpr7wa
kG2p9797WjfKcnC+ZMEEnOVdUFj9c19raxczIjFffzC40Z/6FECt1qksTdUFE/0M
JvkM3SkCgYEA/AgwMdbJREA6sjl0UHu6eJLiurHCJTkrOSBzDXZy42gY55sMnnAa
nhEp7rXowr0QDBg1jPt2fhAdlD7PEzyAjBkQ83GT8d6GzlUrLe/IBRnRgZV7NoxR
KvKwenvU+c6AVyA0+ztztiZytLBKVtHC6iSIEQYOBnVIbUv1oLwAkPUCgYEA6wae
tHdrV6kIGGdcVnqO7a3bzXyareADmsRcWsrIF3PVwTveh5hL/zrwtzdEMhve+PWg
o1dNduRgZtVIEa9uT3jrmDinkM9d78b7PpCWn6cANv3WsBoP7CBL5E/r2KJSozdM
i80VU/wMKvdsLhofVPnanrRec04T0s2OjgpCSI8CgYACPPhgmO20o3Vh+8yiolan
l3ZX/hghSH6vxTAAYJrolhYSiHf2ODykRra+nfLxN8iasuRW2izVNcNte5lPLGxf
0iEqaEnODhHYZz047TYzhWUs52zusRRPc1RJ4iukBEdzfp+5029VoMXIAQDIAJjg
h26F6C3btNLt1Yza3pCKuQKBgQCg8lecnmsUDN1OWPoS/rsCaR0tCzeh+tZ9Fhto
0ZVU+i5XtfgeQ11H28UcsuwwpIV9WDg5o3+Y+6xIv6Yq9khEhDpSc/nMYTWjDlDf
94QusN6kyhBLaI2e1j8iitin8gFFZIk286q3aNOsWOPsblcmijP8muhTbhSFN993
xe6+YQKBgG0p2FoasrUHvnOrIAeTOvF4NFBlM4ltTd4Rhq8wFR5Grke1WoOuWgqT
g9nHbyBEj3DOmc2Fblw/ZCHBLpsBxJz4ZLg8HBw5e/vwJgwB5lleCX2NtcMUexiU
O2r++Q1rZg2t89Xox0B73ugtVFwkLg5eh3eYjUbCNiRUcb/Mf+FX
-----END RSA PRIVATE KEY-----
';
}