<?php

namespace App\Http\Swagger;

abstract class ResetPasswordController
{
    /**
     * @OA\Post(
     *     path="/reset/send",
     *     summary="Send password reset request",
     *     tags={"Reset password"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(
     *             type="array"
     *         ),
     *     )
     * )
     */

    abstract public function createMessage();

    /**
     * @OA\Post(
     *     path="/reset",
     *     summary="Reset password",
     *     tags={"Reset password"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         description="User token from email",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(
     *             type="array"
     *         ),
     *     )
     * )
     */
    abstract public function resetPassword();
}
