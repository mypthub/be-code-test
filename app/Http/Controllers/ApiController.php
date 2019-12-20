<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Serializers\DefaultSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $body;

    /**
     * @var
     */
    protected $transformer;

    /**
     * AbstractApiController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return JsonResponse
     */
    public function respond(): JsonResponse
    {
        return \response()->json($this->body, $this->getStatusCode());
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode ?? Response::HTTP_OK;
    }

    /**
     * @param int $statusCode
     *
     * @return ApiController
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $key
     * @param        $data
     *
     * @return ApiController
     */
    public function appendBody(string $key, $data, $mainObject = false): self
    {
        if ($mainObject) {
            $this->body[$key] = $data;
            return $this;
        }
        $this->body['data'][$key] = $data;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return ApiController
     */
    public function appendError(string $message): self
    {
        return $this->appendBody('error', $message)
                    ->setStatusCode(Response::HTTP_FORBIDDEN);
    }

    /**
     * @param string            $key
     * @param                   $data
     * @param array|string|null $includes
     *
     * @return ApiController
     */
    public function transformItem(string $key, $data, $includes = null): self
    {
        $item = fractal()
            ->item($data, $this->getTransformer())
            ->serializeWith(self::getSerializer())
            ->parseIncludes(Arr::wrap($includes))
            ->toArray();

        $this->appendBody($key, $item);

        return $this;
    }

    /**
     * @param string            $key
     * @param                   $data
     * @param array|string|null $includes
     *
     * @return ApiController
     */
    public function transformCollection(string $key, $data, $includes = null): self
    {
        $collection = fractal()
            ->collection($data, $this->getTransformer())
            ->serializeWith(self::getSerializer())
            ->parseIncludes(Arr::wrap($includes))
            ->toArray();

        $this->appendBody($key, $collection);

        return $this;
    }

    /**
     * @return DefaultSerializer
     */
    public static function getSerializer(): DefaultSerializer
    {
        return new DefaultSerializer();
    }

    /**
     * @return mixed
     */
    public function getDefaultTransformer()
    {
        $class = '\\App\\Transformers\\';

        $class = $class . ucfirst($this->request->get('_controller')) . 'Transformer';

        $class = new $class();

        return new $class();
    }

    /**
     * @param $transformer
     *
     * @return ApiController
     */
    public function setTransformer($transformer): self
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer ?? $this->getDefaultTransformer();
    }

    /**
     * @param $data
     *
     * @return ApiController
     */
    public function withPagination($data): self
    {
        if (method_exists($data, 'total')) {
            return $this->appendBody('pagination', [
                'total' => (int)$data->total(),
                'per_page' => (int)$data->perPage(),
                'current_page' => (int)$data->currentPage(),
                'last_page' => (int)$data->lastPage(),
            ], true);
        }

        return $this->appendBody('pagination', [
            'total' => \count($data),
            'per_page' => 0,
            'current_page' => 1,
            'last_page' => 1,
        ], true);
    }
}
