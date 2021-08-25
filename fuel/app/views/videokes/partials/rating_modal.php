<a class="button rounded-corners modal-link" data-toggle="modal" data-target="#rate_modal"><i class="icon icon-thumbs-up"></i> Rate Now</a>
<div id="rate_modal" class="modal hide fade rounded-corners">
    <div class="modal-header clearfix">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Rate This Video</h3>
    </div>
    <?= Form::open(array('action' => 'videokes/rate','id' => 'modal-rating-form'));?>
        <?= Form::hidden('id',$videoke->id);?>
        <div class="modal-body">
            <div class="option">
                <p>
                    <?=Form::radio('rating',2,array('id' => 'love-it'));?>
                    <span>
                        <?=Form::label('Love it','love-it');?>
                        <span class="points">(2 Pts)</span>
                    </span>
                </p>
            </div>
            <div class="option">
                <p>
                    <?=Form::radio('rating',1,array('id' => 'like-it'));?>
                    <span>
                        <?=Form::label('Like it','like-it');?>
                        <span class="points">(1 Pt)</span>
                    </span>
                </p>
            </div>
            <div class="option">
                <p>
                    <?=Form::radio('rating',0,array('id' => 'okay'));?>
                    <span>
                        <?=Form::label('It\'s okay','okay');?>
                        <span class="points">(0 Pts)</span>
                    </span>
                </p>
            </div>
            <div class="option">
                <p>
                    <?=Form::radio('rating',-1,array('id' => 'dislike-it'));?>
                    <span>
                        <?=Form::label('Dislike it','dislike-it');?>
                        <span class="points">(-1 Pts)</span>
                    </span>
                </p>
            </div>
            <div class="option">
                <p>
                    <?=Form::radio('rating',-2,array('id' => 'hate-it'));?>
                    <span>
                        <?=Form::label('Hate it','hate-it');?>
                        <span class="points">(-2 Pts)</span>
                    </span>
                </p>
            </div>
        </div>
        <div class="modal-footer rounded-corners-bottom">        
            <p>
                <input type="button" class="button rounded-corners" value="Submit" />
                <a href="#" class="button rounded-corners" data-dismiss="modal">Close</a>
            </p>
        </div>
    <?= Form::close();?>
</div>
