<?php

/**
 *  @OpenAPI(
 *      @OA\Server(url=SERVER_V1, description="Server v1")
 *  )
 *
 *  @OA\Info(
 *      title=APP_NAME,
 *      version="1.0.0",
 *      description="REST API for Sapienza application",
 *      @OA\Contact(
 *          email="hardik.iroid@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      ),
 *  )
 *
 *  @OA\SecurityScheme(type="http", securityScheme="BearerAuth", scheme="bearer", bearerFormat="JWT"),
 *
 *
 */

/**
 *  @OA\Post(path="/register", summary="Register a new user", tags={"Auth"},
 *     @OA\RequestBody(description="Register a new app user", required=true,
 *         @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="sepienza"),
 *                 @OA\Property(property="email", type="string", example="sepienza.dev@mailinator.com"),
 *                 @OA\Property(property="password", type="string", example="password"),
 *                 @OA\Property(property="password_confirmation", type="string", example="password"),
 *                 required={"name","email","password","password_confirmation"}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="201", description="Registered successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="409", description="The email has already been taken",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Post(path="/login", summary="Login user", tags={"Auth"},
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", example="sepienza.dev@mailinator.com"),
 *                 @OA\Property(property="password", type="string", example="password"),
 *                 required={"email", "password"}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Logged in successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Post(path="/forgot-password", summary="Forgot password", tags={"Auth"},
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", example="sepienza.dev@mailinator.com"),
 *                  required={"email"}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="200", description="An email has been sent to your inbox",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\get(
 *  path="/logout",
 *  tags={"Auth"},
 *  security={{ "BearerAuth"={} }},
 *  summary="User logout",
 *  @OA\Response(response="200", description="Logout successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/change-password", summary="Change password", tags={"Common"}, security={{ "BearerAuth"={} }},
 *     description="***NOTE: On successfull change password, all the access & refresh tokens relating to that user will be revoked.So, users logged in from multiple devices will be logged out forcefully. Make sure to request new pair of tokens using the refresh token.***",
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="old_password", type="string", example="password"),
 *                 @OA\Property(property="password", type="string", example="password"),
 *                 @OA\Property(property="password_confirmation", type="string", example="password"),
 *                 required={"old_password", "password", "password_confirmation"},
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Your password has been changed successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Get(
 *  path="/profile",
 *  tags={"Profile"},
 *  security={{ "BearerAuth"={} }},
 *  summary="Profile detail",
 *  description="",
 *  @OA\Response(response="200", description="Detail load successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Post(
 *  path="/edit-profile",
 *  tags={"Profile"},
 *  security={{ "BearerAuth"={} }},
 *  summary="Edit Profile",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="multipart/form-data",
 *          @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Eren Yeger"),
 *                 @OA\Property(property="profile", type="string", format="binary"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Edit Profile successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Post(
 *  path="/set-your-profile",
 *  tags={"Profile"},
 *  security={{ "BearerAuth"={} }},
 *  summary="Set your Profile",
 *  description="electricalConductivity=Flower,Vegetative,Clone,Mother",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="growUnit", type="string", example="Room", enum={"Room","Tent","Bay","Comparment"}),
 *                 @OA\Property(property="electricalConductivity", type="string", example="['Flower','Vegetative']"),
 *                 @OA\Property(property="flower", type="integer", example="10"),
 *                 @OA\Property(property="clone", type="integer", example="20"),
 *                 @OA\Property(property="mother", type="integer", example="10"),
 *                 @OA\Property(property="vegitative", type="integer", example="10"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Set Profile successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/subsrate/{type}", summary="subsrate list", tags={"Subsrate EC/pH"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]",
 *      @OA\Parameter(in="path", name="type", example="Vegetative",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="search", type="string", example=""),
 *                  @OA\Property(property="samplingDate", type="date", example="2021-10-13"),
 *                  @OA\Property(property="byBatchID", type="text", example="B1009"),
 *                  @OA\Property(property="byRoomID", type="text", example="4"),
 *                  @OA\Property(property="byCultivar", type="text", example="Tahoe"),
 *                  @OA\Property(property="limit", type="integer", example="10"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *  )
 */

/**
 *  @OA\Get(path="/batchid-list/{type}/{comparmentNo}", summary="batch ID list", tags={"Subsrate EC/pH"}, security={{ "BearerAuth"={} }},description="Type => [Flower,Vegetative,Clone,Mother]",
 *     @OA\Parameter(in="path", name="type", example="Flower",
 *          @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(in="path", name="comparmentNo", example="1",
 *          @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/subsrate",
 *  tags={"Subsrate EC/pH"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store subsrate",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="comparmentNo", type="integer", example="1"),
 *                 @OA\Property(property="batchID", type="integer", example="1"),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="samplingDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="eC", type="string", example="2.9"),
 *                 @OA\Property(property="pH", type="string", example="4.3"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/subsrate/{id}",
 *  tags={"Subsrate EC/pH"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit subsrate",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="comparmentNo", type="integer", example="1"),
 *                 @OA\Property(property="batchID", type="integer", example="1"),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="samplingDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="eC", type="string", example="2.9"),
 *                 @OA\Property(property="pH", type="string", example="4.3"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/subsrate/{id}",
 *  tags={"Subsrate EC/pH"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete subsrate",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Subsrate deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/batch-suggestion", summary="batch suggestion", tags={"Batch"}, security={{ "BearerAuth"={} }},description="",
 *    @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="search", type="string", example=""),
 *          )
 *      )
 *    ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Get(path="/batch/details/{id}", summary="batch list", tags={"Batch"}, security={{ "BearerAuth"={} }},
 *     @OA\Parameter(in="path", name="id", example="1",
 *          @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/batch",
 *  tags={"Batch"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store batch",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="comparmentNo", type="integer", example="1"),
 *                 @OA\Property(property="batchID", type="string", example="PK001"),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="plantingDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="triggerDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="harvestDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="transplantDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="cloneDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="cullDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Batch added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/batch/{id}",
 *  tags={"Batch"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit batch",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="comparmentNo", type="integer", example="1"),
 *                 @OA\Property(property="batchID", type="string", example="PK001"),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="plantingDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="triggerDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="harvestDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="transplantDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="cloneDate", type="string", example="05 Jan,2021"),
 *                 @OA\Property(property="cullDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/batch/{id}",
 *  tags={"Batch"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete batch",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Batch deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/subsrate-target/{type}", summary="subsrate target list", tags={"Subsrate EC/pH Targets"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]",
 *      @OA\Parameter(in="path", name="type", example="Flower",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                  @OA\Property(property="startDate", type="string", example="2020-07-01"),
 *                  @OA\Property(property="limit", type="integer", example="10"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/subsrate-target",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store subsrate target",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="startDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate target added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/subsrate-target/{id}",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit subsrate target",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="startDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate target edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/subsrate-target/{id}",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete Subsrate target",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Subsrate target deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Get(path="/subsrate-target-sub/{subsrateTargetID}", summary="subsrate target list", tags={"Subsrate EC/pH Targets"}, security={{ "BearerAuth"={} }},description="",
 *     @OA\Parameter(in="path", name="subsrateTargetID", example="1",
 *          @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/subsrate-target-sub",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store subsrate target",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="subsrateTargetID", type="integer", example="1"),
 *                 @OA\Property(property="fromDay", type="integer", example="1"),
 *                 @OA\Property(property="toDay", type="integer", example="7"),
 *                 @OA\Property(property="ecMinMax", type="string", example="2.0-1.5"),
 *                 @OA\Property(property="phMinMax", type="string", example="2.0-1.5"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate target sub added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/subsrate-target-sub/{id}",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit subsrate target",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="fromDay", type="integer", example="1"),
 *                 @OA\Property(property="toDay", type="integer", example="7"),
 *                 @OA\Property(property="ecMinMax", type="string", example="2.0-1.5"),
 *                 @OA\Property(property="phMinMax", type="string", example="2.0-1.5"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Subsrate target sub edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/subsrate-target-sub/{id}",
 *  tags={"Subsrate EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete Subsrate target",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Subsrate target sub deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/feed/{type}", summary="subsrate target list", tags={"Feed EC/pH Targets"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]",
 *      @OA\Parameter(in="path", name="type", example="Flower",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                  @OA\Property(property="startDate", type="string", example="2020-07-01"),
 *                  @OA\Property(property="limit", type="integer", example="10"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/feed",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store feed",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="startDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Feed added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/feed/{id}",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit feed",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="comparment", type="string", example="Flower", enum={"Flower","Vegetative","Clone","Mother"}),
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="startDate", type="string", example="05 Jan,2021"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Feed edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/feed/{id}",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete feed",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Feed deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Get(path="/feed-sub/{feedID}", summary="feed sub list", tags={"Feed EC/pH Targets"}, security={{ "BearerAuth"={} }},description="",
 *     @OA\Parameter(in="path", name="feedID", example="1",
 *          @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Post(
 *  path="/feed-sub",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="store feed sub",
 *  description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="feedID", type="integer", example="1"),
 *                 @OA\Property(property="fromDay", type="integer", example="1"),
 *                 @OA\Property(property="toDay", type="integer", example="7"),
 *                 @OA\Property(property="ecMinMax", type="string", example="2.0-1.5"),
 *                 @OA\Property(property="phMinMax", type="string", example="2.0-1.5"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Feed sub added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(
 *  path="/feed-sub/{id}",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="edit feed sub",
 *  description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="fromDay", type="integer", example="1"),
 *                 @OA\Property(property="toDay", type="integer", example="7"),
 *                 @OA\Property(property="ecMinMax", type="string", example="2.0-1.5"),
 *                 @OA\Property(property="phMinMax", type="string", example="2.0-1.5"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Feed sub sub edit successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Delete(
 *  path="/feed-sub/{id}",
 *  tags={"Feed EC/pH Targets"},
 *  security={{ "BearerAuth"={} }},
 *  summary="delete feed sub",
 *   description="",
 *   @OA\Parameter(in="path", name="id", required=true, example="1"),
 *  @OA\Response(response="200", description="Feed sub deleted successfully",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 *  @OA\Post(path="/dashboard", summary="main dashboard", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="type", type="string", example="Flower"),
 *                 @OA\Property(property="search", type="string", example="comparment"),
 *          )
 *      )
 *  ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Get(path="/dashboard/graph/{batchId}", summary="Get Graph", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="",
 *      @OA\Parameter(in="path", name="batchId", required=true, example="1"),
 *      @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *  )
 */

/**
 *  @OA\Post(path="/dashboard/batch", summary="batch & historic list", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]
 *      Batch Select => [1 => EC & pH Batch, 2 => EC & pH Historic]
 *      By Date => [1 => Last Month, 2 => Last 6 Month, 3 => Last 12 Month]",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="type", type="string", example="Flower"),
 *                 @OA\Property(property="batchselect", type="string", example="1"),
 *                 @OA\Property(property="byDate", type="string", example="1"),
 *                 @OA\Property(property="cutomDate", type="string", example="1"),
 *                 @OA\Property(property="byBatchID", type="string", example="PK001"),
 *                 @OA\Property(property="byRoomID", type="string", example="Flower Comparment 1"),
 *                 @OA\Property(property="byCultivar", type="string", example="Pink Kush"),
 *          )
 *      )
 *  ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Post(path="/dashboard/custom-graph", summary="custom graph", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="
 *      Type => [Flower,Vegetative,Clone,Mother]",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="type", type="string", example="Flower"),
 *                 @OA\Property(property="search", type="string", example="comparment"),
 *          )
 *      )
 *  ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Post(path="/dashboard/targets", summary="Dashboard Target", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="
 *       section => [Feed,Subrate]
 *       Type => [Flower,Vegetative,Clone,Mother]",
 *       @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                   @OA\Property(property="section", type="string", example="Feed"),
 *                   @OA\Property(property="type", type="string", example="Flower"),
 *             )
 *          )
 *       ),
 *       @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *       @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *       @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *  )
 */

/**
 *  @OA\Post(path="/dashboard/historic", summary="Dashboard historic", tags={"Dashboard"}, security={{ "BearerAuth"={} }}, description="
 *       Type => [Flower,Vegetative,Clone,Mother]",
 *       @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="type", type="string", example="Flower"),
 *                 @OA\Property(property="byDate", type="string", example=""),
 *                 @OA\Property(property="cutomDate", type="string", example=""),
 *                 @OA\Property(property="byBatchID", type="string", example=""),
 *                 @OA\Property(property="byRoomID", type="string", example=""),
 *                 @OA\Property(property="byCultivar", type="string", example=""),
 *             )
 *          )
 *       ),
 *       @OA\Response(response="200", description="successfully",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *       @OA\Response(response="401", description="Unauthenticated",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *       @OA\Response(response="422", description="Validation error",
 *          @OA\MediaType(mediaType="application/json")
 *       ),
 *  )
 */

/**
 *  @OA\Post(path="/subsrate/dashboard/update", summary="Update Ec, Ph value form dashboard", tags={"Dashboard"}, security={{ "BearerAuth"={} }},description="",
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="subsrateID", type="string", example="1"),
 *                 @OA\Property(property="eC", type="string", example="1"),
 *                 @OA\Property(property="pH", type="string", example="1"),
 *          )
 *      )
 *  ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Get(path="/cultivar/{type}", summary="Get Cultivar list", tags={"Cultivar"}, security={{ "BearerAuth"={} }} ,description="
 *      Type => [all,Flower,Vegetative,Clone,Mother]",
 *     @OA\Parameter(in="path", name="type", example="all",
 *          @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 *  @OA\Get(path="/variety-master?status=", summary="Get variety master list", tags={"Variety Master"}, security={{ "BearerAuth"={} }} , description="status:1=archive,0=active",
 *     @OA\Parameter(in="query", name="status", required=false, example=""),
 *     @OA\Response(response="200", description="successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="401", description="Unauthenticated",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */

/**
 * @OA\Post(path="/variety-master", summary="Store variety master", tags={"Variety Master"}, security={{ "BearerAuth"={} }},
 *  @OA\RequestBody(description="", required=true,
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="archive", type="boolen", example="false"),
 *          )
 *      )
 *  ),
 *  @OA\Response(response="200", description="Variety master added successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
 * @OA\Put(path="/variety-master/{id}", summary="edit variety master", tags={"Variety Master"}, security={{ "BearerAuth"={} }},
 *      @OA\Parameter(in="path", name="id", required=true, example="1"),
 *      @OA\RequestBody(description="", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *              @OA\Schema(
 *                 @OA\Property(property="cultivar", type="string", example="Pink Kush"),
 *                 @OA\Property(property="archive", type="boolen", example="false"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Variety master edit successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Invalid Request params",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 * )
 */

/**
 * @OA\Delete(path="/variety-master/{id}", summary="delete Variety Master", tags={"Variety Master"}, security={{ "BearerAuth"={} }},
 *      @OA\Parameter(in="path", name="id", required=true, example="1"),
 *      @OA\Response(response="200", description="Variety master deleted successfully",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 *      @OA\Response(response="422", description="Invalid Request params",
 *          @OA\MediaType(mediaType="application/json")
 *      ),
 * )
 */
