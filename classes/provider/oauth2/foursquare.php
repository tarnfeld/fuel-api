<?php

namespace Api;

class Api_Foursquare extends Api_OAuth2
{
	public function api_url()
	{
		return 'https://api.foursquare.com/v2/%s';
	}

	public function token_key()
	{
		return 'oauth_token';
	}

	public function callback($request)
	{
		try
		{
			$data = $request->execute();
			$data = json_decode($data);
		}
		catch (\RequestStatusException $e)
		{
			$message = 'An error occurred connecting to the Foursquare servers';
			$data = json_decode($e->getMessage());

			if (isset($data->meta->errorDetail))
			{
				$message = $data->meta->errorDetail;
			}

			throw new ApiException($message);
		}
		catch (\Exception $e)
		{
			throw new ApiException($e->getMessage());
		}

		return $data->response;
	}
}