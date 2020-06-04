package sidescroller.animator;


import java.util.Iterator;
import java.util.function.Consumer;

import javafx.scene.canvas.Canvas;
import javafx.scene.canvas.GraphicsContext;
import javafx.scene.layout.Background;
import javafx.scene.paint.Color;
import sidescroller.entity.player.Player;
import sidescroller.entity.property.Drawable;
import sidescroller.entity.property.Entity;
import sidescroller.entity.property.HitBox;

public class Animator extends AbstractAnimator{
	private Color background = Color.ANTIQUEWHITE;

	public void handle(GraphicsContext gc, long now) {
		updateEntities();
		clearAndFill(gc, background);
		drawEntities(gc);
	}

	@Override
	public void drawEntities(GraphicsContext gc) {
		Consumer<Entity> draw = e ->{
			if(e != null && e.isDrawable()) {
				e.getDrawable().draw(gc);
				if(map.getDrawBounds() && e.hasHitbox()) {
					e.getHitBox().getDrawable().draw(gc);
				}
			}
		};
		draw.accept(map.getBackground());
		map.staticShapes().forEach(draw);
		map.players().forEach(draw);;
	}

	@Override
	public void updateEntities() {
		for(Entity player : map.players()) {
			player.update();
		}
		for(Entity sEntity : map.staticShapes()) {
			sEntity.update();
		}
		
		if(map.getDrawBounds()) {
			for(Entity pEntity : map.players()) {
				pEntity.getHitBox().getDrawable().setStroke(Color.RED);
			}
		}
		for(Entity entity : map.staticShapes()) {
			proccessEntityList(map.players().iterator(), entity.getHitBox());
		}
		
	}

	@Override
	public void proccessEntityList(Iterator<Entity> iterator, HitBox shapeHitBox) {
		while(iterator.hasNext()) {
			Entity entity = iterator.next();
			HitBox bounds = entity.getHitBox();
			
			if(!map.inMap(bounds)) {
				updateEntity(entity,iterator);
			} else if(shapeHitBox != null && bounds.intersectBounds(shapeHitBox)) {
				if(map.getDrawBounds()) {
					bounds.getDrawable().setStroke(Color.BLUEVIOLET);
				}
				updateEntity(entity, iterator);
			}
			
			
		}
		
	}

	@Override
	public void updateEntity(Entity entity, Iterator<Entity> iterator) {
		if(entity instanceof Player) {
			((Player) entity).stepBack();
		}
		
	}

}
