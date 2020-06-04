package sidescroller.scene;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.function.BiFunction;

import org.hamcrest.core.Is;

import com.sun.rowset.internal.Row;

import javafx.beans.property.BooleanProperty;
import javafx.beans.property.SimpleBooleanProperty;
import javafx.scene.canvas.Canvas;
import javafx.scene.layout.Background;
import sidescroller.animator.AnimatorInterface;
import sidescroller.entity.property.Entity;
import sidescroller.entity.property.HitBox;
import sidescroller.entity.sprite.tile.BackgroundTile;
import sidescroller.entity.sprite.tile.FloraTile;
import sidescroller.entity.sprite.tile.ItemTile;
import sidescroller.entity.sprite.tile.Tile;
import utility.Tuple;

public class MapScene implements MapSceneInterface{
	private Tuple count;
	private Tuple size;
	private double scale;
	private AnimatorInterface animator;
	private List<Entity> players;
	private List<Entity> staticShapes;
	private BooleanProperty drawBounds;
	private BooleanProperty drawFPS;
	private BooleanProperty drawGrid;
	private Entity background;
	
	public MapScene() {
		players = new ArrayList<Entity>();
		staticShapes = new ArrayList<Entity>();
		drawBounds = new SimpleBooleanProperty();
		drawFPS = new SimpleBooleanProperty();
		drawGrid = new SimpleBooleanProperty();
	}

	@Override
	public BooleanProperty drawFPSProperty() {
		return drawFPS;
	}

	@Override
	public boolean getDrawFPS() {
		return drawFPSProperty().get();
	}

	@Override
	public BooleanProperty drawBoundsProperty() {
		return drawBounds;
	}

	@Override
	public boolean getDrawBounds() {
		return drawBoundsProperty().get();
	}

	@Override
	public BooleanProperty drawGridProperty() {
		return drawGrid;
	}

	@Override
	public boolean getDrawGrid() {
		return drawGridProperty().get();
	}

	@Override
	public MapScene setRowAndCol(Tuple count, Tuple size, double scale) {
		this.count = count;
		this.size = size;
		this.scale = scale;
		return this;
	}

	@Override
	public Tuple getGridCount() {
		return count;
	}

	@Override
	public Tuple getGridSize() {
		return size;
	}
	
	@Override
	public double getScale() {
		return scale;
	}
	
	@Override
	public void start() {
		if(animator!=null) {
			animator.start();
		}
	}

	@Override
	public void stop() {
		if(animator!=null) {
			animator.stop();
		}
		
	}


	@Override
	public List<Entity> staticShapes() {
		return staticShapes;
	}

	@Override
	public List<Entity> players() {
		return players;
	}

	@Override
	public MapScene createScene(Canvas canvas) {
		MapBuilder mb = MapBuilder.createBuilder();
		mb.setCanvas(canvas);
		mb.setGrid(getGridCount(), getGridSize());
		mb.setGridScale(getScale());
		BiFunction<Integer, Integer, Tile> callback = (row, col) ->{
			if(row == new Random().nextInt(3)) {
				return BackgroundTile.EVENING_CLOUD;
			}
			return BackgroundTile.EVENING;
			
		};
		
		mb.buildBackground(callback);
		mb.buildLandMass(7, 12, 4, 6);
		mb.buildLandMass(2, 4, 1, 4);
		mb.buildLandMass(3, 20, 2, 3);
		mb.buildLandMass(3, 30, 1, 3);
		mb.buildLandMass(12, 27, 2, 3);
		mb.buildLandMass(1, 10, 1, 2);
		mb.buildLandMass(13, 8, 1, 4);
		mb.buildTree(4, 2, FloraTile.TREE);
		mb.buildTree(4, 23, FloraTile.TREE);
		mb.buildTree(11, 28, FloraTile.FLOWER_PINK);
		mb.buildTree(12, 10, FloraTile.FLOWER_PURPLE);
		mb.buildTree(11, 8, FloraTile.SUNFLOWER_SHORT);
		mb.buildTree(5, 14, FloraTile.SUNFLOWER_LONG);
		mb.buildTree(14, 0, FloraTile.BUSH);
		mb.buildTree(14, 1, FloraTile.BUSH);
		mb.buildTree(14, 2, FloraTile.BUSH);
		mb.buildTree(14, 5, FloraTile.FLOWER_RED);
		mb.buildTree(14, 6, FloraTile.FLOWER_YELLOW);
		mb.buildTree(14, 7, FloraTile.FLOWER_PINK);
		mb.buildTree(10, 3, FloraTile.BUSH);
		mb.buildTree(10, 2, FloraTile.BUSH);
		mb.buildTree(10, 6, FloraTile.BUSH);
		mb.buildTree(14, 18, FloraTile.BUSH);
		mb.buildTree(14, 19, FloraTile.BUSH);
		mb.buildTree(14, 20, FloraTile.FLOWER_RED);
		mb.buildTree(14, 34, FloraTile.BUSH);
		mb.buildTree(14, 33, FloraTile.BUSH);
		mb.buildTree(14, 32, FloraTile.FLOWER_RED);
		mb.buildTree(14, 21, FloraTile.FLOWER_YELLOW);
		mb.buildTree(14, 22, FloraTile.FLOWER_PINK);
		mb.buildTree(10, 24, FloraTile.BUSH);
		mb.buildTree(10, 27, FloraTile.BUSH);
		mb.buildTree(10, 28, FloraTile.BUSH);
		mb.buildTree(2, 21, ItemTile.SIGN);
		mb.buildTree(13, 2, ItemTile.COIN_LEFT);
		mb.buildTree(5, 9, ItemTile.COIN_LEFT);
		mb.buildTree(4, 11, ItemTile.COIN_LEFT);
		mb.buildTree(3, 13, ItemTile.COIN_LEFT);
		mb.buildTree(2, 15, ItemTile.COIN_LEFT);
		mb.buildTree(7, 20, ItemTile.COIN_LEFT);
		mb.buildTree(9, 20, ItemTile.COIN_LEFT);
		mb.buildTree(11, 20, ItemTile.COIN_LEFT);
		mb.buildTree(5, 32, ItemTile.COIN_LEFT);
		mb.buildTree(7, 32, ItemTile.COIN_LEFT);
		mb.buildTree(9, 32, ItemTile.COIN_LEFT);
		mb.buildTree(11, 32, ItemTile.COIN_LEFT);
		background=mb.getBackground();
		mb.getEntities(staticShapes);
		
		return this;
	}

	@Override
	public boolean inMap(HitBox hitbox) {
		return background.getHitBox().containsBounds(hitbox);
	}

	@Override
	public MapScene setAnimator(AnimatorInterface newAnimator) throws NullPointerException{
		if(animator!=null) {
			stop();
		}
		animator=newAnimator;
		return this;
	}

	@Override
	public Entity getBackground() {
		return background;
	}

}
