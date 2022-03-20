<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Promotion;
use App\Models\PromotionUser;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use Request;

class WalletController extends Controller
{
    public function listPromotion($id = null)
    {
        try {
            $promotions = Promotion::query()->with('users.wallet');
            if (!is_null($id)) {
                $promotions->where('promotions.id', $id);
            }
            $promotions->select('promotions.*');
            $promotions = $promotions->get();
            return response()->json(['success' => true, 'data' => $promotions]);

        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
    public function savePromotion()
    {
        try {
            $validator = Validator::make(request()->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'amount' => 'required|numeric',
                'quota' => 'required|integer'
            ],
                [
                    'start_date.required' => 'Başlangıç tarihi zorunludur!',
                    'start_date.date' => 'Başlangıç tarihi için veri tipi uyumsuz!',
                    'end_date.required' => 'Bitiş tarihi zorunludur!',
                    'end_date.date' => 'Bitiş tarihi için veri tipi uyumsuz!',
                    'amount.required' => 'Promosyon tutarı zorunludur!',
                    'amount.numeric' => 'Promosyon tutarı için veri tipi uyumsuz!',
                    'quota.required' => 'Kota miktarı zorunludur!',
                    'quota.integer' => 'Kota miktarı için veri tipi uyumsuz!',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->messages();
                return response()->json(['status' => 'error', 'message' => $messages], 422);
            }
            $start_date=Request::input('start_date');
            $end_date=Request::input('end_date');
            $amount=Request::input('amount');
            $quota=Request::input('quota');

            $promotions = new Promotion();
            $promotions->code=Helpers::generateStringKey(12);
            $promotions->start_date=$start_date;
            $promotions->end_date=$end_date;
            $promotions->amount=$amount;
            $promotions->quato=$quota;
            $promotions->save();

            $data=Promotion::find($promotions->id);

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function assignPromotion()
    {
         $code=Request::input('code');
         $username=Request::input('username');
         $promotion=Promotion::whereCode($code)->first();
         if(empty($promotion)){
             return response()->json(['success' => false, 'message' => "Girilen koda ait promosyon bulunamadı!"]);
         }
         $user=User::whereUsername($username)->first();
         if (empty($user)){
             return response()->json(['success' => false, 'message' => "Kullanıcı bulunamadı!"]);
         }
         $promotion_user=PromotionUser::whereUser($user->id)->wherePromotion($promotion->id)->count();
         if ($promotion_user>0){
             return response()->json(['success' => false, 'message' => "Aynı promosyon daha önce kullanılmıştır!"]);
         }
         $default_quato=$promotion->quato;
         $using_quato=PromotionUser::wherePromotion($promotion->id)->count();

         if ($using_quato<$default_quato && $promotion->start_date<=now() && $promotion->end_date>=now()){
             $promotion_user=new PromotionUser();
             $promotion_user->promotion=$promotion->id;
             $promotion_user->user=$user->id;
             $promotion_user->save();

             $wallet=Wallet::whereUser($user->id)->first();
             $wallet->balance+=$promotion->amount;
             $wallet->save();
             return response()->json(['success' => true]);
         }else{
             return response()->json(['success' => false, 'message' => "Promosyon kotası dolmuştur!"]);
         }
    }
}
