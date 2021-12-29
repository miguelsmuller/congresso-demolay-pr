<h1>Comentários</h1>
<div id="comments" class="panel panel-default">
    <div class="panel-body">

        <?php if ( post_password_required() ) { ?>
            <p class="nocomments">Este artigo é protegido por senha. Insira-a para ver os comentários.</p>
        <?php return; } ?>

        <?php if ( have_comments() ) : ?>
            <ol class="list-unstyled">
                <?php
                    $args = array(
                        'avatar_size' => '64',
                        'type'        => 'comment',
                        'callback'    => 'list_comment'
                    );
                    wp_list_comments($args);
                    ?>
            </ol>

            <?php if ($wp_query->max_num_pages > 1) : ?>
                <ul class="pagination">
                    <li class="older"><?php previous_comments_link('Anteriores'); ?></li>
                    <li class="newer"><?php next_comments_link('Novos'); ?></li>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( comments_open() ) : ?>
            <h1>Deixe o seu comentário</h1>

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-<?php if ( $user_ID ) : echo '12'; else : echo '6'; endif;  ?>">
                            <?php if ( $user_ID ) : ?>
                                <p>Autentificado como <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="Sair desta conta">Sair desta conta &raquo;</a></p>

                            <?php else : ?>
                                <div class="form-group">
                                    <label for="author">*Nome: </label>
                                    <input type="text" name="author" class="form-control" value="<?php echo $comment_author; ?>" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="email">*Seu Email: </label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $comment_author_email; ?>" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="url">Website:</label>
                                    <input type="text" name="url" class="form-control">
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="col-xs-<?php if ( $user_ID ) : echo '12'; else : echo '6'; endif;  ?>">
                            <div class="form-group">
                                <label for="url">Mensagem:</label>
                                <textarea name="comment" class="form-control" rows="7"></textarea>
                            </div>

                            <input type="submit" class="btn btn-default" value="Enviar Comentário" />

                            <?php comment_id_fields(); ?>
                            <?php do_action('comment_form', $post->ID); ?>
                        </div>
                    </div>
                </fieldset>
            </form>
            <p class="cancel"><?php cancel_comment_reply_link('Cancelar Resposta'); ?></p>
        <?php else : ?>
            <h2>Os comentários estão fechados.</h2>
        <?php endif; ?>
    </div>
</div>