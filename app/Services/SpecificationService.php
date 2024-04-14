<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Specification;
use App\Models\Attribute;

class SpecificationService
{
    public function addSpecificationToCategory($request, $category)
    {
        DB::beginTransaction();
        try {
            $specification = Specification::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
            ]);

            if ($request->input("attributes") && count($request->input("attributes"))) {
                foreach ($request->input("attributes") as $attribute) {
                    if (!$attribute) {
                        continue;
                    }

                    Attribute::create([
                        'specification_id' => $specification->id,
                        'key' => $attribute,
                    ]);
                }
            }

            DB::commit();
            return $specification;
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() != 0) {
                throw new \Exception("Add specification to category failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function updateSpecification($request, $specificationId)
    {
        DB::beginTransaction();
        try {
            $specification = Specification::find($specificationId)->update([
                'name' => $request->name,
                'updated_at' => now()
            ]);

            if ($request->input('attributes') && count($request->input("attributes"))) {
                Attribute::where('specification_id', $specificationId)->delete();

                foreach ($request->input("attributes") as $attribute) {
                    if (!$attribute) {
                        continue;
                    }

                    Attribute::create([
                        'specification_id' => $specificationId,
                        'key' => $attribute,
                    ]);
                }
            }

            DB::commit();
            return $specification;
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() != 0) {
                throw new \Exception('Edit specification failed');
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function removeSpecificationFromCategory($specificationIds)
    {
        $position = null;
        try {
            if (!is_array($specificationIds)) {
                $specificationIds = [$specificationIds];
            }

            foreach ($specificationIds as $index => $specificationId) {
                $specification = Specification::find($specificationId);

                if (!$specification) {
                    throw new \InvalidArgumentException('Specification is not found in position ' . $index + 1);
                }

                $status = $specification->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Delete specification failed in position " . $position + 1);
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
}