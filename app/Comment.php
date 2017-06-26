<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['body','user_id','discussion_id'];
    /**得到某条评论的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function user()
   {
       return $this->belongsTo(User::class);
   }

    /**得到某条评论的帖子
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function discussion()
   {
        return $this->belongsTo(Discussion::class);
   }
}
